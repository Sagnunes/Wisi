<?php

declare(strict_types=1);

namespace App\Contracts\Permission;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    public function all(): Collection;

    public function find(string $uuid): Permission;

    public function create(array $data): Permission;

    public function update(Permission $permission, array $data): Permission;

    public function delete(Permission $permission): bool;

    public function paginate(int $perPage);
}
