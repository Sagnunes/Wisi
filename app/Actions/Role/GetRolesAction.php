<?php

declare(strict_types=1);

namespace App\Actions\Role;

use App\Contracts\Role\RoleServiceInterface;

final readonly class GetRolesAction
{
    public function __construct(private RoleServiceInterface $service) {}

    public function handle(): array
    {
        return $this->service->getRoles();
    }
}
