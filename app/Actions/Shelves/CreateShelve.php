<?php

declare(strict_types=1);

namespace App\Actions\Shelves;

use App\Contracts\Services\ShelveServiceInterface;
use App\DTOs\ShelveDTO;

final readonly class CreateShelve
{
    public function __construct(private ShelveServiceInterface $service) {}

    public function handle(ShelveDTO $dto): ShelveDTO
    {
        return $this->service->createShelve($dto);
    }
}
