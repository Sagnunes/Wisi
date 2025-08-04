<?php

declare(strict_types=1);

namespace App\Actions\Role;

use App\Contracts\Services\RoleServiceInterface;
use App\Models\Role;

final readonly class DeleteRole
{
    public function __construct(private RoleServiceInterface $service) {}

    public function handle(Role $role): bool
    {
        return $this->service->deleteRole($role);
    }
}
