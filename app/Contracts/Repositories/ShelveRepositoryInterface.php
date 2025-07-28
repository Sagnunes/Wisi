<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Shelve;
use Illuminate\Database\Eloquent\Collection;

interface ShelveRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Shelve;

    public function create(array $data): Shelve;

    public function update(Shelve $shelve, array $data): Shelve;

    public function delete(Shelve $shelve): bool;
}
