<?php

declare(strict_types=1);

namespace App\Actions\UserStatus;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;

final readonly class UpdateUserStatus
{
    public function __construct(private UserServiceInterface $service) {}

    public function handle(User $user, int $statusId): bool
    {
        return $this->service->updateStatus($user, $statusId);
    }
}
