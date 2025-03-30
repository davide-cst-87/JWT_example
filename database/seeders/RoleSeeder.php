<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Normal User Role
        Role::create(['name' => 'user']);

        // Company Roles
        $companyAdmin = Role::create(['name' => 'company-admin']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $staff = Role::create(['name' => 'staff']);

        // Define permissions
        Permission::create(['name' => 'manage company']);
        Permission::create(['name' => 'manage workers']);
        Permission::create(['name' => 'view company dashboard']);

        // Assign permissions
        $companyAdmin->givePermissionTo(['manage company', 'manage workers', 'view company dashboard']);
        $supervisor->givePermissionTo(['manage workers', 'view company dashboard']);
        $staff->givePermissionTo(['view company dashboard']);
    }
}