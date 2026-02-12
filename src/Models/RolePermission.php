<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

namespace enuenan\UsersRolesPermissions\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    use HasUuids;

    protected $table = 'role_permissions';

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'role_id',
        'permission_id',
    ];
}
