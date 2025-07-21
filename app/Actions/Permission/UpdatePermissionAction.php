<?php

namespace App\Actions\Permission;

use App\Contracts\Permission\PermissionServiceInterface;
use App\DTOs\Permission\PermissionDTO;
use App\Models\Permission;

final readonly class UpdatePermissionAction
{
    public function __construct(private PermissionServiceInterface $service)
    {
    }

    public function handle(Permission $permission, PermissionDTO $dto): PermissionDTO
    {
        return $this->service->updatePermission($permission, $dto);
    }
}
