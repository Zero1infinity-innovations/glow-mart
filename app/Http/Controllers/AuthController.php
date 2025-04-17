<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'mobile'    => 'required|digits:10|unique:users',
            'password'  => 'required|min:6',
            'shop_id'   => 'required',
            'pincode'   => 'required',
        ]);

        $roles = Roles::where('guard_name', 'user')->first();
        $user = User::create([
            'role_id'   => $roles->id,
            'shop_id'   => $request->shop_id,
            'name'      => $request->name,
            'email'     => $request->email,
            'pincode'   => $request->pincode,
            'mobile'    => $request->mobile,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Registration successful'], 200);
    }

    // Login User
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = User::where(function($query) use ($request) {
            $query->where('email', $request->login)->orWhere('mobile', $request->login);
        })->where('role_id', 2)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return response()->json(['message' => 'Login successful'], 200);
        }

        return response()->json(['message' => 'Invalid credentials for user'], 401);
    }

    // Logout User
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
