<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;

final readonly class UserService implements UserServiceInterface
{
    public function __construct(private UserRepository $repository) {}

    public function getUsers(): array
    {
        return $this->repository->all()
            ->map(fn (User $user): UserDTO => UserDTO::fromModel($user))
            ->toArray();
    }

    public function deleteUser(User $user): bool
    {
        return $this->repository->delete($user);
    }
}
