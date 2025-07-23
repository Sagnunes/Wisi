<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function getUsers(): array;

    public function deleteUser(User $user): bool;

    public function updateStatus(User $user, int $status): bool;

    public function syncRoles(User $user, array $roles): array;
}
