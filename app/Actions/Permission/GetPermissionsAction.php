<?php

declare(strict_types=1);

namespace App\Actions\Permission;

use App\Contracts\Permission\PermissionServiceInterface;

final readonly class GetPermissionsAction
{
    public function __construct(private PermissionServiceInterface $service) {}

    public function handle(): array
    {
        return $this->service->getPermissions();
    }
}
