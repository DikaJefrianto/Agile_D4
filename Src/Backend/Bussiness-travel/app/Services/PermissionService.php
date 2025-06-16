<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * Get all permissions organized by groups
     */
    public function getAllPermissions(): array
    {
        return [
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                ],
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                    'user.approve',
                    'user.login_as',
                ],
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ],
            ],
            [
                'group_name' => 'module',
                'permissions' => [
                    'module.create',
                    'module.view',
                    'module.edit',
                    'module.delete',
                ],
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    'profile.view',
                    'profile.edit',
                    'profile.delete',
                    'profile.update',
                ],
            ],
            [
                'group_name' => 'monitoring',
                'permissions' => [
                    'pulse.view',
                    'actionlog.view',
                ],
            ],
            [
                'group_name' => 'settings',
                'permissions' => [
                    'settings.view',
                    'settings.edit',
                ],
            ],
            [
                'group_name' => 'translations',
                'permissions' => [
                    'translations.view',
                    'translations.edit',
                ],
            ],
            [
                'group_name' => 'perusahaan',
                'permissions' => [
                    'perusahaan.view',
                    'perusahaan.create',
                    'perusahaan.edit',
                    'perusahaan.delete',
                ],
            ],
            [
                'group_name' => 'bahanbakar',
                'permissions' => [
                    'bahanbakar.view',
                    'bahanbakar.create',
                    'bahanbakar.edit',
                    'bahanbakar.delete',
                ],
            ],
            [
                'group_name' => 'transportasi',
                'permissions' => [
                    'transportasi.view',
                    'transportasi.create',
                    'transportasi.edit',
                    'transportasi.delete',
                ],
            ],
            [
                'group_name' => 'biaya',
                'permissions' => [
                    'biaya.view',
                    'biaya.create',
                    'biaya.edit',
                    'biaya.delete',
                ],
            ],
            [
                'group_name' => 'perhitungan',
                'permissions' => [
                    'perhitungan.view',
                    'perhitungan.create',
                    'perhitungan.edit',
                    'perhitungan.delete',
                ],
            ],
        ];
    }

    public function getPermissionsByGroup(string $groupName): ?array
    {
        foreach ($this->getAllPermissions() as $permissionGroup) {
            if ($permissionGroup['group_name'] === $groupName) {
                return $permissionGroup['permissions'];
            }
        }

        return null;
    }

    public function getPermissionGroups(): array
    {
        return array_column($this->getAllPermissions(), 'group_name');
    }

    public function getAllPermissionModels(): Collection
    {
        return Permission::all();
    }

    public function getPermissionModelsByGroup(string $group_name): Collection
    {
        return Permission::select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
    }

    public function getDatabasePermissionGroups(): Collection
    {
        return Permission::select('group_name as name')
            ->groupBy('group_name')
            ->get();
    }

    public function createPermissions(): array
    {
        $createdPermissions = [];

        foreach ($this->getAllPermissions() as $permissionGroup) {
            $groupName = $permissionGroup['group_name'];

            foreach ($permissionGroup['permissions'] as $permissionName) {
                $createdPermissions[] = $this->findOrCreatePermission($permissionName, $groupName);
            }
        }

        return $createdPermissions;
    }

    public function findOrCreatePermission(string $name, string $groupName): Permission
    {
        return Permission::firstOrCreate(
            ['name' => $name, 'guard_name' => 'web'],
            ['group_name' => $groupName]
        );
    }

    public function getPermissionsByNames(array $permissionNames): array
    {
        return Permission::whereIn('name', $permissionNames)->get()->all();
    }

    public function getPaginatedPermissionsWithRoleCount(string $search = null, ?int $perPage): LengthAwarePaginator
    {
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('group_name', 'like', '%' . $search . '%');
        }

        $permissions = $query->paginate($perPage ?? config('settings.default_pagination'));

        foreach ($permissions as $permission) {
            $roles = $permission->roles()->get();
            $permission->role_count = $roles->count();
            $permission->roles_list = $roles->pluck('name')->take(5)->implode(', ');

            if ($permission->role_count > 5) {
                $permission->roles_list .= ', ...';
            }
        }

        return $permissions;
    }

    public function getRolesForPermission(Permission $permission): Collection
    {
        return $permission->roles()->get();
    }
}
