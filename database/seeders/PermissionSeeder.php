<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'group'=>'role',
            'name'=>'role-create',
        ]);
        Permission::create([
            'group'=>'role',
            'name'=>'role-delete',
        ]);
        Permission::create([
            'group'=>'role',
            'name'=>'role-list',
        ]);
        Permission::create([
            'group'=>'role',
            'name'=>'role-edit',
        ]);
        Permission::create([
            'group'=>'category',
            'name'=>'category-edit',
        ]);
        Permission::create([
            'group'=>'category',
            'name'=>'category-list',
        ]);
        Permission::create([
            'group'=>'category',
            'name'=>'category-create',
        ]);
        Permission::create([
            'group'=>'category',
            'name'=>'category-delete',
        ]);
        Permission::create([
            'group'=>'banner',
            'name'=>'banner-delete',
        ]);
        Permission::create([
            'group'=>'banner',
            'name'=>'banner-list',
        ]);
        Permission::create([
            'group'=>'banner',
            'name'=>'banner-edit',
        ]);
        Permission::create([
            'group'=>'banner',
            'name'=>'banner-create',
        ]);

        Permission::create([
            'group'=>'products',
            'name'=>'products-create',
        ]);
        Permission::create([
            'group'=>'products',
            'name'=>'products-list',
        ]);
        Permission::create([
            'group'=>'products',
            'name'=>'products-edit',
        ]);
        Permission::create([
            'group'=>'products',
            'name'=>'products-delete',
        ]);
    }
}
