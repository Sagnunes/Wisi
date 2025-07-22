<?php

declare(strict_types=1);

namespace App\Actions\Permission;

use App\Contracts\Services\PermissionServiceInterface;
use App\DTOs\PermissionDTO;

final readonly class CreatePermissionAction
{
    public function __construct(private PermissionServiceInterface $service) {}

    public function handle(PermissionDTO $dto): PermissionDTO
    {
        return $this->service->createPermission($dto);
    }
}
