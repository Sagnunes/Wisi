<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Repositories\ShelveRepositoryInterface;
use App\Models\Permission;
use App\Models\Shelve;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final readonly class ShelveRepository implements ShelveRepositoryInterface
{
    /**
     * The columns to select from the shelves table
     */
    private const SHELVE_LIST_COLUMNS = ['id', 'name', 'slug', 'created_at', 'updated_at', 'deleted_at'];

    public function __construct(private Shelve $model) {}

    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function find(int $id): Shelve
    {
        return $this->baseQuery()->findOrFail($id);
    }

    public function create(array $data): Shelve
    {
        return $this->model->create($data);
    }

    public function update(Shelve $shelve, array $data): Shelve
    {
        $shelve->update($data);

        return $shelve->fresh();
    }

    public function delete(Shelve $shelve): bool
    {
        return $shelve->delete();
    }

    private function baseQuery(): Builder
    {
        return $this->model->query()->withTrashed()->select(self::SHELVE_LIST_COLUMNS)->orderBy('name');
    }
}
