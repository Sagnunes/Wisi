<?php

declare(strict_types=1);

namespace App\Contracts\Fund;

use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface FundRepositoryInterface
{
    public function all(): Collection;

    public function findAllWithPreviewDigitalObject(): Collection;

    public function findWithDigitalObject(Fund $fund, ?string $search = null): LengthAwarePaginator;
}
