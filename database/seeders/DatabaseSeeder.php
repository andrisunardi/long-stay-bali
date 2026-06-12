<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            OauthSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,

            DistrictSeeder::class,
            AreaSeeder::class,
            ValueSeeder::class,
            StandardSeeder::class,

            GuideCategorySeeder::class,
            GuideSeeder::class,

            PropertySeeder::class,
            PropertyImageSeeder::class,

            ContactSeeder::class,
        ]);
    }
}
