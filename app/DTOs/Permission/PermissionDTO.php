<?php

declare(strict_types=1);

namespace App\DTOs\Permission;

use App\Models\Permission;
use Illuminate\Support\Str;

final readonly class PermissionDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $uuid,
        public ?string $description = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}

    public static function fromRequest(array $data, ?string $uuid = null): self
    {
        return new self(
            name: $data['name'],
            slug: Str::slug($data['name']),
            uuid: $uuid ?? ($data['uuid'] ?? Str::uuid()->toString()),
            description: $data['description'] ?? null,
        );
    }

    public static function fromModel(Permission $permission): self
    {
        return new self(
            name: $permission->name,
            slug: $permission->slug,
            uuid: $permission->uuid,
            description: $permission->description,
            created_at: $permission->created_at->format('Y-m-d'),
            updated_at: $permission->updated_at->format('Y-m-d'),
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
        ];
    }
}
