<?php

declare(strict_types=1);

namespace App\DTOs\Role;

use App\Contracts\DTO\DTOInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final readonly class RoleDTO implements DTOInterface
{
    public function __construct(
        public string      $name,
        public string      $slug,
        public string      $uuid,
        public ?string     $description = null,
        public ?string     $created_at = null,
        public ?string     $updated_at = null,
        public ?Collection $permissions = null,
    )
    {
    }

    public static function fromRequest(array $data, ?string $uuid = null): self
    {
        return new self(
            name: $data['name'],
            slug: Str::slug($data['name']),
            uuid: $uuid ?? ($data['uuid'] ?? Str::uuid()->toString()),
            description: $data['description'] ?? null,
        );
    }

    public static function fromModel(Model|Role $model): self
    {
        return new self(
            name: $model->name,
            slug: $model->slug,
            uuid: $model->uuid,
            description: $model->description,
            created_at: $model->created_at->format('Y-m-d'),
            updated_at: $model->updated_at->format('Y-m-d'),
            permissions: $model->permissions,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'permissions' => collect($this->permissions ?? [])->map(fn($permission): array => [
                'uuid' => $permission->uuid,
                'name' => $permission->name,
                'slug' => $permission->slug,
            ])->toArray(),
        ];
    }
}
