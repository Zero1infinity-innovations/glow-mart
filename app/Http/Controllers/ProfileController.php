<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $categories = Category::all();
        $user = Auth::user();
        $shop = Shop::where('id', Auth::user()->shop_id)->first();
        $count = Cart::where('user_id', $user_id)->count();
        return view('userlogin.profile', compact('user', 'shop', 'count', 'categories'));
    }

    public function changePasswordView()
    {
        return view('userlogin.changePassword');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation
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

        // Ensure directory exists
        $profileImagePath = public_path('uploads/profile_images');
        if (!file_exists($profileImagePath)) {
            mkdir($profileImagePath, 0777, true);
        }

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($profileImagePath, $imageName);

            // Delete old image if it exists and is not default
            if ($user->profile_image && $user->profile_image != 'default.png') {
                $oldImagePath = $profileImagePath . '/' . $user->profile_image;
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath); // Use @unlink to suppress warning
                }
            }

            $user->profile_image = $imageName;
        }

        // Update other fields
        $user->name = $request->name;
        $user->shop_id = $request->shop_id;
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
