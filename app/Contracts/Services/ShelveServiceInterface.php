<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\DTOs\PermissionDTO;
use App\DTOs\ShelveDTO;
use App\Models\Permission;
use App\Models\Shelve;

interface ShelveServiceInterface
{
    public function getShelve(int $id): ShelveDTO;

    public function getShelves(): array;

    public function createShelve(ShelveDTO $dto): ShelveDTO;

    public function updateShelve(Shelve $shelve, ShelveDTO $dto): ShelveDTO;

    public function deleteShelve(Shelve $shelve): bool;
}
