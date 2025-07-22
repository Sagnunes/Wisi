<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\DTOs\PermissionDTO;
use App\Models\Permission;

interface PermissionServiceInterface
{
    public function getPermission(int $id): PermissionDTO;

    public function getPermissions(): array;

    public function createPermission(PermissionDTO $dto): PermissionDTO;

    public function updatePermission(Permission $permission, PermissionDTO $dto): PermissionDTO;

    public function deletePermission(Permission $permission): bool;
}
