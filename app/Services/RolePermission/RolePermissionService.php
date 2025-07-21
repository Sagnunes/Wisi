<?php

namespace App\Services\RolePermission;

use App\Models\Role;

class RolePermissionService
{
    /**
     * Assign a set of permissions to a role (syncs all).
     */
    public function syncPermissions(Role $role, array $permissionIds): array
    {
        return $role->permissions()->sync($permissionIds);
    }

    /**
     * Attach a single permission to the role.
     */
    public function attachPermission(Role $role, int|string $permissionId): void
    {
        $role->permissions()->attach($permissionId);
    }

    /**
     * Detach a single permission from the role.
     */
    public function detachPermission(Role $role, int|string $permissionId): void
    {
        $role->permissions()->detach($permissionId);
    }
}
