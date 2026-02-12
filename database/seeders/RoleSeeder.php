<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

namespace enuenan\UsersRolesPermissions\Database\Seeders;

use enuenan\UsersRolesPermissions\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            ['identifier' => Role::ADMIN],
            [
                'role' => 'Admin',
                'all_permission' => true,
                'is_active' => true,
            ]
        );
    }
}
