<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name'=>'Admin'
        ]);

        $user =User::create([
            'name'=>'admin',
            "email"=>"admin@gmail.com",
            "password"=>Hash::make('123456'),
        ]);
        $user->assignRole(Role::first());
    }
}
