<?php

declare(strict_types=1);

namespace App\Actions\RolePermission;

use App\Models\Role;
use App\Services\RolePermissionService;

final readonly class SyncPermissionsToRoleAction
{
    public function __construct(private RolePermissionService $service) {}

    public function handle(Role $role, array $permissionsUuids): array
    {
        return $this->service->syncPermissions($role, $permissionsUuids);
    }
}
