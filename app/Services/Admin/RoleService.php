<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function createRole(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $role = Role::create($data);

            return $role;
        });
    }

    public function updateRole(Role $role, array $data): Role
    {
        return DB::transaction(function () use ($role, $data) {
            $role->update($data);

            return $role;
        });
    }

    public function deleteRole(Role $role): void //using void as it does not return anything
    {
        DB::transaction(function () use ($role) {
            $role->delete();
        });
    }

    public function createPermission(array $data)
    {
        return DB::transaction(function () use ($data) {
            $permission = Permission::create($data);

            return $permission;
        });
    }

    public function updatePermission(Permission $permission, array $data): Permission
    {
        return DB::transaction(function () use ($permission, $data) {
            $permission->update($data);

            return $permission;
        });
    }

    public function deletePermission(Permission $permission): void //using void as it does not return anything
    {
        DB::transaction(function () use ($permission) {
            $permission->delete();
        });
    }

    // Roles Permissions Assignment

    public function storeRolePermissions(array $data): void
    {
        DB::transaction(function () use ($data) {
            $role = Role::findById($data['role']);
            $role->syncPermissions(
                Permission::whereIn('id', $data['permissions'])
                    ->where('guard_name', $role->guard_name)
                    ->pluck('name')
            );
        });
    }

    public function updateRolePermissions(Role $role, array $data): void
    {
        DB::transaction(function () use ($role, $data) {
            $permissionNames = Permission::whereIn('id', $data['permissions'])
                ->where('guard_name', $role->guard_name)
                ->pluck('name');

            $role->syncPermissions($permissionNames);
        });
    }
    public function deleteRolePermissions(Role $role): void
    {
        DB::transaction(function () use ($role) {
            $role->permissions()->detach();
        });
    }
}
