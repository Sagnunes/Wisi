<?php

declare(strict_types=1);

namespace App\Actions\Role;

use App\Contracts\Role\RoleServiceInterface;
use App\Models\Role;

final readonly class DeleteRoleAction
{
    public function __construct(private RoleServiceInterface $service) {}

    public function handle(Role $role): bool
    {
        return $this->service->deleteRole($role);
    }
}
