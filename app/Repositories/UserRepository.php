<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final readonly class UserRepository implements UserRepositoryInterface
{
    /**
     * The columns to select from the user table
     */
    private const USER_LIST_COLUMNS = ['id', 'name', 'email', 'status_id', 'created_at', 'updated_at'];

    public function __construct(private User $model) {}

    public function all(): Collection
    {
        return $this->baseQuery()->with(['status','roles'])->get();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    private function baseQuery(): Builder
    {
        return $this->model->query()->select(self::USER_LIST_COLUMNS)->orderBy('name');
    }
}
