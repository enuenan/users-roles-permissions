<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

namespace enuenan\UsersRolesPermissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('permissions:sync');
    }
}
