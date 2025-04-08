<?php

namespace App\Http\Controllers\Admin\Auth;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\Admin\Auth\LoginRequest;

class AuthController extends Controller
{
    public function login() {
        return view('admin.auth.login');
    }

    public function doLogin(LoginRequest $request) {
        try{
            if(!Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')])):
                return response()->json([
                    'status'=>false,
                    'message'=>"Invalid Credentials,Please try again !"
                ],500);
            else:
                request()->session()->regenerate();
                $checkUser = User::where('email', $request->input('email'))->first();
                if($checkUser->role_id == 1){
                    return response()->json([
                        'status'=>true,
                        'message'=>"Login Successfully, Please Wait redirecting....",
                        'url'=>route('admin.dashboard')
                    ],200);
                }else{
                    return response()->json([
                        'status'=>true,
                        'message'=>"Login Successfully, Please Wait redirecting....",
                        'url'=>route('admin.shop.dashboard')
                    ],200);
                }
            endif;
        }catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }
}
