<?php

declare(strict_types=1);

namespace App\Contracts\DTO;

use Illuminate\Database\Eloquent\Model;

interface DTOInterface
{
    public static function fromRequest(array $data, ?string $uuid = null): self;

    public static function fromModel(Model $model): self;

    public function toArray(): array;
}
