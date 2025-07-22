<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Contracts\Services\RoleServiceInterface;
use App\DTOs\RoleDTO;
use App\Models\Role;
use App\Traits\HasPaginationFormatting;

final readonly class RoleService implements RoleServiceInterface
{
    use HasPaginationFormatting;

    public function __construct(private RoleRepositoryInterface $repository) {}

    private function toDto(Role $role): RoleDTO
    {
        return RoleDTO::fromModel($role);
    }

    private function dtoToAttributes(RoleDTO $dto): array
    {
        return [
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ];
    }

    public function getRole(int $id): RoleDTO
    {
        $role = $this->repository->find($id);

        return $this->toDto($role);
    }

    public function getRoles(): array
    {
        return $this->repository->all()
            ->map(fn (Role $role): RoleDTO => $this->toDto($role))
            ->toArray();
    }

    public function getRoleWithPermission(int $id): RoleDTO
    {
        $role = $this->repository->withPermission($id);
        return $this->toDto($role);
    }

    public function createRole(RoleDTO $dto): RoleDTO
    {
        $role = $this->repository->create($this->dtoToAttributes($dto));

        return $this->toDto($role);
    }

    public function updateRole(Role $role, RoleDTO $dto): RoleDTO
    {
        $updatedRole = $this->repository->update(
            $role,
            $this->dtoToAttributes($dto)
        );

        return $this->toDto($updatedRole);
    }

    public function deleteRole(Role $role): bool
    {
        return $this->repository->delete($role);
    }
}
