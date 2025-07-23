<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Contracts\DTO\DTOInterface;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class UserDTO implements DTOInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public Status $status,
        public string $created_at,
        public ?string $updated_at,
        public ?int $id = null,
        public ?Collection $roles = null,

    ) {}

    public static function fromRequest(array $data): DTOInterface
    {
        // TODO: Implement fromRequest() method.
    }

    public static function fromModel(Model|User $model): self
    {
        return new self(
            name: $model->name,
            email: $model->email,
            status: $model->status,
            created_at: $model->created_at->format('Y-m-d'),
            updated_at: $model->updated_at->format('Y-m-d'),
            id: $model->id,
            roles: $model->roles ?? null,

        );
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}
