<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '12345678901',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'image_url' => null,
            'is_active' => true,
        ])->assignRole('Admin');
    }
}
