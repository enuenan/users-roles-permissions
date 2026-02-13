<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

declare(strict_types=1);

namespace enuenan\UsersRolesPermissions\Models;

use Filament\Panel;
use Spatie\Image\Enums\Fit;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\InteractsWithMedia;
use Mattiverse\Userstamps\Traits\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
// use Wildside\Userstamps\Userstamps;

trait HasRole
{
    use InteractsWithMedia, SoftDeletes, Userstamps;

    public const DEFAULT_IMAGE_URL = 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png';

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->fit(Fit::Max, 300, 300)
            ->nonQueued();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getFirstMediaUrl('profile-images', 'avatar');
    }

    public function isOnline(): bool
    {
        return Cache::has('user-is-online.' . $this->id);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
