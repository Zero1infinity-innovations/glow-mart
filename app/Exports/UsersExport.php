<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $query = User::where('role_id', 2)->with('shop');

        if (Auth::check() && Auth::user()->role_id == 3) {
            $query->where('shop_id', Auth::user()->shop_id);
        }

        $users = $query->get();

        return $users->map(function ($user) {
            return [
                'name'      => $user->name,
                'shop_name' => $user->shop ? $user->shop->shop_name : 'N/A',
                'email'     => $user->email,
                'mobile'    => $user->mobile,
                'address'   => $user->address,
                'city'      => $user->city,
                'state'     => $user->state,
                'pincode'   => $user->pincode,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Shop Name',
            'Email',
            'Mobile No',
            'Address',
            'City',
            'State',
            'Pincode',
        ];
    }
}
