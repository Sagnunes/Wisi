<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Repositories\ShelveRepositoryInterface;
use App\Contracts\Services\PermissionServiceInterface;
use App\Contracts\Services\ShelveServiceInterface;
use App\DTOs\PermissionDTO;
use App\DTOs\ShelveDTO;
use App\Models\Permission;
use App\Models\Shelve;
use App\Traits\HasPaginationFormatting;

final readonly class ShelveService implements ShelveServiceInterface
{
    use HasPaginationFormatting;

    public function __construct(private ShelveRepositoryInterface $repository)
    {
    }

    public function getShelve(int $id): ShelveDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    public function getShelves(): array
    {
        return $this->repository->all()
            ->map(fn(Shelve $shelve): ShelveDTO => $this->toDto($shelve))
            ->toArray();
    }

    public function createShelve(ShelveDTO $dto): ShelveDTO
    {
        $shelve = $this->repository->create($this->dtoToAttributes($dto));

        return $this->toDto($shelve);
    }

    public function updateShelve(Shelve $shelve, ShelveDTO $dto): ShelveDTO
    {
        $updatedShelve = $this->repository->update(
            $shelve,
            $this->dtoToAttributes($dto)
        );

        return $this->toDto($updatedShelve);
    }

    public function deleteShelve(Shelve $shelve): bool
    {
        return $this->repository->delete($shelve);
    }

    private function toDto(Shelve $shelve): ShelveDTO
    {
        return ShelveDTO::fromModel($shelve);
    }

    private function dtoToAttributes(ShelveDTO $dto): array
    {
        return [
            'name' => $dto->name,
            'slug' => $dto->slug,
        ];
    }
}
