<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['name' => 'user', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'user.add', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'user.edit', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'user.delete', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'user.detail', 'guard_name' => 'web'])->assignRole('Admin');

        Permission::create(['name' => 'role', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'role.add', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'role.edit', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'role.delete', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'role.detail', 'guard_name' => 'web'])->assignRole('Admin');

        Permission::create(['name' => 'permission', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'permission.add', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'permission.edit', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'permission.delete', 'guard_name' => 'web'])->assignRole('Admin');
        Permission::create(['name' => 'permission.detail', 'guard_name' => 'web'])->assignRole('Admin');
    }
}
