<?php

declare(strict_types=1);

namespace App\Actions\Shelves;

use App\Contracts\Services\ShelveServiceInterface;

final readonly class GetShelves
{
    public function __construct(private ShelveServiceInterface $service) {}

    public function handle(): array
    {
        return $this->service->getShelves();
    }
}
