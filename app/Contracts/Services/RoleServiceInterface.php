<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\DTOs\RoleDTO;
use App\Models\Role;

interface RoleServiceInterface
{
    public function getRole(int $id): RoleDTO;

    public function getRoles(): array;

    public function createRole(RoleDTO $dto): RoleDTO;

    public function updateRole(Role $role, RoleDTO $dto): RoleDTO;

    public function deleteRole(Role $role): bool;

    public function getRoleWithPermission(int $id): RoleDTO;
}
