<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class RoleRepository implements RoleRepositoryInterface
{
    /**
     * The columns to select from the role table
     */
    private const ROLE_LIST_COLUMNS = ['id', 'name', 'slug', 'description', 'created_at', 'updated_at'];

    public function __construct(private Role $model) {}

    public function find(int $id): Role
    {
        return $this->baseQuery()->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->baseQuery()->with('permissions')->get();
    }

    public function withPermission(int $id): Role
    {
        return $this->baseQuery()->with('permissions')->findOrFail($id);
    }

    public function create(array $data): Role
    {
        return $this->model->create($data);
    }

    public function update(Role $role, array $data): Role
    {
        $role->update($data);

        return $role->fresh();
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function paginateWithPermissions(int $perPage = 15): LengthAwarePaginator
    {
        return $this->baseQuery()->with('permissions')->paginate($perPage)->withQueryString();
    }

    private function baseQuery(): Builder
    {
        return $this->model->query()->select(self::ROLE_LIST_COLUMNS)->orderBy('name');
    }
}
