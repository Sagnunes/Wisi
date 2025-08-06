<?php

declare(strict_types=1);

namespace App\Actions\Shelves;

use App\Contracts\Services\ShelveServiceInterface;
use App\DTOs\ShelveDTO;
use App\Models\Shelve;

final readonly class UpdateShelve
{
    public function __construct(private ShelveServiceInterface $service) {}

    public function handle(Shelve $shelve, ShelveDTO $dto): ShelveDTO
    {
        return $this->service->updateShelve($shelve, $dto);
    }
}
