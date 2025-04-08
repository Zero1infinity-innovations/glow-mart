<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('userlogin.profile', ['user' => Auth::user()]);
    }

    public function changePasswordView()
    {
        return view('userlogin.changePassword');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|digits:10|unique:users,mobile,' . $user->id,
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|digits:6',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profileImagePath = public_path('uploads/profile_images');
        if (!file_exists($profileImagePath)) {
            mkdir($profileImagePath, 0777, true); // Create directory with full permissions
        }

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_images'), $imageName);

            // Delete Old Profile Image
            if ($user->profile_image && file_exists(public_path('uploads/profile_images/' . $user->profile_image))) {
                unlink(public_path('uploads/profile_images/' . $user->profile_image));
            }

            $user->profile_image = $imageName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->pincode = $request->pincode;
        $user->address = $request->address;
        $user->save();

        

        return response()->json(['message' => 'Profile updated successfully!']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'New password and confirm password do not match!',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect!'], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Password changed successfully!']);
    }
}
