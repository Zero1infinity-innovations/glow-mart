<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashBoardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logOut()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', "You're account has been logout");
    }

    public function getUserDetails()
    {
        if (Auth::check() && Auth::user()->role_id == 3) {
            $data = User::where('role_id', 2)->where('shop_id', Auth::user()->shop_id)->with('shop')->get();
        } else {
            // $data = User::where('role_id', 2)->get();
            $data = User::where('role_id', 2)->with('shop')->get();
        }
        return view('admin.users.index', compact('data'));
    }

    public function exportUsers(){
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
