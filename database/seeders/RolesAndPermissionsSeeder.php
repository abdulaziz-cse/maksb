<?php

namespace Database\Seeders;

use Database\Seeders\BaseSeeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'consumer']);
    }
}
