<?php

declare(strict_types=1);

namespace App\Actions\Role;

use App\Contracts\Role\RoleServiceInterface;
use App\DTOs\Role\RoleDTO;

final readonly class CreateRoleAction
{
    public function __construct(private RoleServiceInterface $service) {}

    public function handle(RoleDTO $dto): RoleDTO
    {
        return $this->service->createRole($dto);
    }
}
