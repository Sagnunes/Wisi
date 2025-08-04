<?php

declare(strict_types=1);

namespace App\Actions\Role;

use App\Contracts\Services\RoleServiceInterface;

final readonly class GetRoles
{
    public function __construct(private RoleServiceInterface $service) {}

    public function handle(): array
    {
        return $this->service->getRoles();
    }
}
