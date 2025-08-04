<?php

declare(strict_types=1);

namespace App\Actions\UserRole;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;

final readonly class UpdateUserRole
{
    public function __construct(private UserServiceInterface $service) {}

    public function handle(User $user, array $roles): array
    {
        return $this->service->syncRoles($user, $roles);
    }
}
