<?php

declare(strict_types=1);

namespace App\Actions\Permission;

use App\Contracts\Services\PermissionServiceInterface;

final readonly class GetPermissions
{
    public function __construct(private PermissionServiceInterface $service) {}

    public function handle(): array
    {
        return $this->service->getPermissions();
    }
}
