<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Services\PermissionServiceInterface;
use App\DTOs\PermissionDTO;
use App\Models\Permission;
use App\Traits\HasPaginationFormatting;

final readonly class PermissionService implements PermissionServiceInterface
{
    use HasPaginationFormatting;

    public function __construct(private PermissionRepositoryInterface $repository) {}

    private function toDto(Permission $permission): PermissionDTO
    {
        return PermissionDTO::fromModel($permission);
    }

    private function dtoToAttributes(PermissionDTO $dto): array
    {
        return [
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ];
    }

    public function getPermission(int $id): PermissionDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    public function getPermissions(): array
    {
        return $this->repository->all()
            ->map(fn (Permission $permission): PermissionDTO => $this->toDto($permission))
            ->toArray();
    }

    public function createPermission(PermissionDTO $dto): PermissionDTO
    {
        $permission = $this->repository->create($this->dtoToAttributes($dto));

        return $this->toDto($permission);
    }

    public function updatePermission(Permission $permission, PermissionDTO $dto): PermissionDTO
    {
        $updatedPermission = $this->repository->update(
            $permission,
            $this->dtoToAttributes($dto)
        );

        return $this->toDto($updatedPermission);
    }

    public function deletePermission(Permission $permission): bool
    {
        return $this->repository->delete($permission);
    }
}
