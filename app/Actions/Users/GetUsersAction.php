<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Contracts\Services\UserServiceInterface;

final readonly class GetUsersAction
{
    public function __construct(private UserServiceInterface $service) {}

    public function handle(): array
    {
        return $this->service->getUsers();
    }
}
