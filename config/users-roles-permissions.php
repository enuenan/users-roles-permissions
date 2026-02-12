<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

use enuenan\UsersRolesPermissions\Filament\Clusters\UserManager;
use enuenan\UsersRolesPermissions\Filament\Clusters\UserManager\Resources\PermissionResource;
use enuenan\UsersRolesPermissions\Filament\Clusters\UserManager\Resources\RoleResource;
use enuenan\UsersRolesPermissions\Filament\Clusters\UserManager\Resources\UserResource;
use enuenan\UsersRolesPermissions\Filament\Exports\PermissionExporter;
use enuenan\UsersRolesPermissions\Filament\Imports\PermissionImporter;

return [
    'cluster' => UserManager::class,
    'resource' => [
        'user' => UserResource::class,
        'role' => RoleResource::class,
        'permission' => PermissionResource::class,
    ],
    'manager' => [
        'user' => 'enuenan\UsersRolesPermissions\Filament\Clusters\UserManager\Resources\UserResource\Pages\ManageUsers',
        'role' => 'enuenan\UsersRolesPermissions\Filament\Clusters\UserManager\Resources\RoleResource\Pages\ManageRoles',
        'permission' => 'enuenan\UsersRolesPermissions\Filament\Clusters\UserManager\Resources\PermissionResource\Pages\ManagePermissions',
    ],
    'export' => [
        'permission' => PermissionExporter::class,
    ],
    'import' => [
        'permission' => PermissionImporter::class,
    ],
];
