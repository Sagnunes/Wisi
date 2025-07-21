<?php

declare(strict_types=1);

namespace App\Contracts\Role;

use App\DTOs\Permission\PermissionDTO;
use App\DTOs\Role\RoleDTO;
use App\Models\Permission;
use App\Models\Role;

interface RoleServiceInterface
{
    public function getRole(string $uuid): RoleDTO;

    public function getRoles(): array;

    public function getAllRolesWithPermissions(int $perPage): array;

    public function createRole(RoleDTO $dto): RoleDTO;

    public function updateRole(Role $role, RoleDTO $dto): RoleDTO;

    public function deleteRole(Role $role): bool;
}
