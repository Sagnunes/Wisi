<?php

declare(strict_types=1);

namespace App\Actions\Shelves;

use App\Contracts\Services\ShelveServiceInterface;
use App\Models\Shelve;

final readonly class DeleteShelve
{
    public function __construct(private ShelveServiceInterface $service) {}

    public function handle(Shelve $shelve): bool
    {
        return $this->service->deleteShelve($shelve);
    }
}
