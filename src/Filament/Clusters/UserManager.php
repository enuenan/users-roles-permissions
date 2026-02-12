<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

namespace enuenan\UsersRolesPermissions\Filament\Clusters;

use enuenan\UsersRolesPermissions\UsersRolesPermissionsServiceProvider;
use Filament\Clusters\Cluster;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class UserManager extends Cluster
{
    public const DEFAULT_DATETIME_FORMAT = 'M-d-Y h:i:s A';

    public static function getNavigationLabel(): string
    {
        return __('users-roles-permissions::users-roles-permissions.user.manager');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return __('users-roles-permissions::users-roles-permissions.user.manager');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationGroup(): ?string
    {
        return __('users-roles-permissions::users-roles-permissions.system');
    }

    public static function getNavigationSort(): ?int
    {
        return 100;
    }

    public static function checkAccess(string $method, ?Model $record = null): bool
    {
        $plugin = Filament::getCurrentPanel()?->getPlugin(UsersRolesPermissionsServiceProvider::$name);
        $access = $plugin->$method();
        if (! empty($access) && is_array($access) && isset($access['ability'], $access['arguments'])) {
            return Gate::allows($access['ability'], $access['arguments']);
        }

        return $access;
    }
}
