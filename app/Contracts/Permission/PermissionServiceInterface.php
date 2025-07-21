<?php

declare(strict_types=1);

namespace App\Contracts\Permission;

use App\DTOs\Permission\PermissionDTO;
use App\Models\Permission;

interface PermissionServiceInterface
{
    public function getPermission(string $uuid): PermissionDTO;

    public function getPermissions(): array;

    public function getPermissionsPaginated(int $perPage = 15): array;

    public function createPermission(PermissionDTO $dto): PermissionDTO;

    public function updatePermission(Permission $permission, PermissionDTO $dto): PermissionDTO;

    public function deletePermission(Permission $permission): bool;
}
