<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // MODULE
        Permission::create(['name' => 'contact'])->assignRole('Admin');
        Permission::create(['name' => 'contact.add'])->assignRole('Admin');
        Permission::create(['name' => 'contact.edit'])->assignRole('Admin');
        Permission::create(['name' => 'contact.delete'])->assignRole('Admin');
        Permission::create(['name' => 'contact.detail'])->assignRole('Admin');

        Permission::create(['name' => 'guide'])->assignRole('Admin');
        Permission::create(['name' => 'guide.add'])->assignRole('Admin');
        Permission::create(['name' => 'guide.edit'])->assignRole('Admin');
        Permission::create(['name' => 'guide.delete'])->assignRole('Admin');
        Permission::create(['name' => 'guide.detail'])->assignRole('Admin');

        Permission::create(['name' => 'guide_category'])->assignRole('Admin');
        Permission::create(['name' => 'guide_category.add'])->assignRole('Admin');
        Permission::create(['name' => 'guide_category.edit'])->assignRole('Admin');
        Permission::create(['name' => 'guide_category.delete'])->assignRole('Admin');
        Permission::create(['name' => 'guide_category.detail'])->assignRole('Admin');

        Permission::create(['name' => 'property'])->assignRole('Admin', 'Agent');
        Permission::create(['name' => 'property.add'])->assignRole('Admin', 'Agent');
        Permission::create(['name' => 'property.edit'])->assignRole('Admin', 'Agent');
        Permission::create(['name' => 'property.delete'])->assignRole('Admin');
        Permission::create(['name' => 'property.detail'])->assignRole('Admin', 'Agent');

        Permission::create(['name' => 'property_image'])->assignRole('Admin', 'Agent');
        Permission::create(['name' => 'property_image.add'])->assignRole('Admin', 'Agent');
        Permission::create(['name' => 'property_image.edit'])->assignRole('Admin', 'Agent');
        Permission::create(['name' => 'property_image.delete'])->assignRole('Admin');
        Permission::create(['name' => 'property_image.detail'])->assignRole('Admin', 'Agent');

        // MASTER
        Permission::create(['name' => 'standard'])->assignRole('Admin');
        Permission::create(['name' => 'standard.add'])->assignRole('Admin');
        Permission::create(['name' => 'standard.edit'])->assignRole('Admin');
        Permission::create(['name' => 'standard.delete'])->assignRole('Admin');
        Permission::create(['name' => 'standard.detail'])->assignRole('Admin');

        Permission::create(['name' => 'value'])->assignRole('Admin');
        Permission::create(['name' => 'value.add'])->assignRole('Admin');
        Permission::create(['name' => 'value.edit'])->assignRole('Admin');
        Permission::create(['name' => 'value.delete'])->assignRole('Admin');
        Permission::create(['name' => 'value.detail'])->assignRole('Admin');

        Permission::create(['name' => 'area'])->assignRole('Admin');
        Permission::create(['name' => 'area.add'])->assignRole('Admin');
        Permission::create(['name' => 'area.edit'])->assignRole('Admin');
        Permission::create(['name' => 'area.delete'])->assignRole('Admin');
        Permission::create(['name' => 'area.detail'])->assignRole('Admin');

        Permission::create(['name' => 'district'])->assignRole('Admin');
        Permission::create(['name' => 'district.add'])->assignRole('Admin');
        Permission::create(['name' => 'district.edit'])->assignRole('Admin');
        Permission::create(['name' => 'district.delete'])->assignRole('Admin');
        Permission::create(['name' => 'district.detail'])->assignRole('Admin');

        // ACCESS
        Permission::create(['name' => 'oauth'])->assignRole('Admin');
        Permission::create(['name' => 'oauth.add'])->assignRole('Admin');
        Permission::create(['name' => 'oauth.edit'])->assignRole('Admin');
        Permission::create(['name' => 'oauth.delete'])->assignRole('Admin');
        Permission::create(['name' => 'oauth.detail'])->assignRole('Admin');

        Permission::create(['name' => 'permission'])->assignRole('Admin');
        Permission::create(['name' => 'permission.add'])->assignRole('Admin');
        Permission::create(['name' => 'permission.edit'])->assignRole('Admin');
        Permission::create(['name' => 'permission.delete'])->assignRole('Admin');
        Permission::create(['name' => 'permission.detail'])->assignRole('Admin');

        Permission::create(['name' => 'role'])->assignRole('Admin');
        Permission::create(['name' => 'role.add'])->assignRole('Admin');
        Permission::create(['name' => 'role.edit'])->assignRole('Admin');
        Permission::create(['name' => 'role.delete'])->assignRole('Admin');
        Permission::create(['name' => 'role.detail'])->assignRole('Admin');

        Permission::create(['name' => 'user'])->assignRole('Admin');
        Permission::create(['name' => 'user.add'])->assignRole('Admin');
        Permission::create(['name' => 'user.edit'])->assignRole('Admin');
        Permission::create(['name' => 'user.delete'])->assignRole('Admin');
        Permission::create(['name' => 'user.detail'])->assignRole('Admin');
    }
}
