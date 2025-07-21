<?php

declare(strict_types=1);

namespace App\Services\Permission;

use App\Contracts\Permission\PermissionRepositoryInterface;
use App\Contracts\Permission\PermissionServiceInterface;
use App\DTOs\Permission\PermissionDTO;
use App\Models\Permission;
use App\Traits\HasPaginationFormatting;

final readonly class PermissionService implements PermissionServiceInterface
{
    use HasPaginationFormatting;

    public function __construct(private PermissionRepositoryInterface $repository) {}

    public function getPermission(string $uuid): PermissionDTO
    {
        return $this->toDto($this->repository->find($uuid));
    }

    public function getPermissions(): array
    {
        return $this->repository->all()
            ->map(fn (Permission $permission): PermissionDTO => $this->toDto($permission))
            ->toArray();
    }

    public function getPermissionsPaginated(int $perPage = 15): array
    {
        $paginated = $this->repository->paginate($perPage);

        $paginated = $paginated->through(fn (Permission $permission) => [
            ...$this->toDto($permission)->toArray(),
            'can' => [
                'update' => auth()->user()?->can('update', $permission) ?? false,
                'delete' => auth()->user()?->can('delete', $permission) ?? false,
            ],
        ]);

        return $this->formatPagination($paginated, fn ($item) => $item);
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

    private function toDto(Permission $permission): PermissionDTO
    {
        return PermissionDTO::fromModel($permission);
    }

    private function dtoToAttributes(PermissionDTO $dto): array
    {
        return [
            'uuid' => $dto->uuid,
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ];
    }
}
