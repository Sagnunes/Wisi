<?php

declare(strict_types=1);

namespace App\Actions\Permission;

use App\Contracts\Services\PermissionServiceInterface;
use App\Models\Permission;

final readonly class DeletePermission
{
    public function __construct(private PermissionServiceInterface $service) {}

    public function handle(Permission $permission): bool
    {
        return $this->service->deletePermission($permission);
    }
}
