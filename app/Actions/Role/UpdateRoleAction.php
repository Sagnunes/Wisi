<?php

declare(strict_types=1);

namespace App\Actions\Role;

use App\Contracts\Services\RoleServiceInterface;
use App\DTOs\RoleDTO;
use App\Models\Role;

final readonly class UpdateRoleAction
{
    public function __construct(private RoleServiceInterface $service) {}

    public function handle(Role $role, RoleDTO $dto): RoleDTO
    {
        return $this->service->updateRole($role, $dto);
    }
}
