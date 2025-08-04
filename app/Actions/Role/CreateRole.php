<?php

declare(strict_types=1);

namespace App\Actions\Role;

use App\Contracts\Services\RoleServiceInterface;
use App\DTOs\RoleDTO;

final readonly class CreateRole
{
    public function __construct(private RoleServiceInterface $service) {}

    public function handle(RoleDTO $dto): RoleDTO
    {
        return $this->service->createRole($dto);
    }
}
