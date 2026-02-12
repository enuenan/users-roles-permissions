<?php

/*
 * Copyright enuenan. All rights reserved.
 * @auth enuenan
 * @link  https://github.com/enuenan
 */

namespace enuenan\UsersRolesPermissions\Filament\Clusters\UserManager\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Ramsey\Collection\Set;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Clusters\Cluster;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use enuenan\UsersRolesPermissions\Models\Role;
use Filament\Schemas\Components\Utilities\Get;
use CodeWithDennis\FilamentSelectTree\SelectTree;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('role')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.name'))
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Set $set) => $set('identifier', Str::slug($state))),
                Forms\Components\TextInput::make('identifier')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.identifier'))
                    ->required()
                    ->disabled()
                    ->maxLength(255)
                    ->dehydrated()
                    ->unique(Role::class, 'identifier', ignoreRecord: true),
                Forms\Components\Toggle::make('all_permission')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.all-permission'))
                    ->default(true)
                    ->live()
                    ->afterStateUpdated(function (Get $get, $state, Set $set) {
                        if ($get('all_permission')) {
                            $set('permission_id', []);
                        }
                    })
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.is-active'))
                    ->required()
                    ->default(true),
                SelectTree::make('permission_id')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.permissions'))
                    ->relationship('permissions', 'permission_with_panel_ids', 'parent_id', function ($query) {
                        return $query->where('status', true);
                    }, function ($query) {
                        return $query->where('status', true);
                    })
                    ->live()
                    ->afterStateUpdated(function (Get $get, $state, Set $set) {
                        if ($get('all_permission')) {
                            $set('all_permission', false);
                        }
                    })
                    ->searchable()
                    ->defaultOpenLevel(2)
                    ->columnSpanFull()
                    ->direction('down'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('identifier')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.identifier'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('all_permission')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.all-permission'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('permissions.permission_with_panel_ids')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.permissions'))
                    ->default('-')
                    ->badge()
                    ->listWithLineBreaks()
                    ->limitList(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.form.is-active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.table.created-at'))
                    ->dateTime(static::$cluster::DEFAULT_DATETIME_FORMAT)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('users-roles-permissions::users-roles-permissions.role.resource.table.updated-at'))
                    ->dateTime(static::$cluster::DEFAULT_DATETIME_FORMAT)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions(
                ActionGroup::make([
                    EditAction::make()->slideOver(),
                    DeleteAction::make(),
                ])
            )
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(function () {
                        return static::$cluster::checkAccess('getCanDeleteRole');
                    }),
                ]),
            ]);
    }

    /**
     * @return class-string<Cluster> | null
     */
    public static function getCluster(): ?string
    {
        return static::$cluster = config('users-roles-permissions.cluster');
    }

    public static function getPages(): array
    {
        return [
            'index' => config('users-roles-permissions.manager.role')::route('/'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('users-roles-permissions::users-roles-permissions.role.resource.role');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return 'heroicon-o-academic-cap';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function canViewAny(): bool
    {
        return static::$cluster::checkAccess('getCanViewAnyRole');
    }

    public static function canCreate(): bool
    {
        return static::$cluster::checkAccess('getCanCreateRole');
    }

    public static function canEdit(Model $record): bool
    {
        return static::$cluster::checkAccess('getCanEditRole', $record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::$cluster::checkAccess('getCanDeleteRole', $record);
    }
}
