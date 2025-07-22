<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface FundServiceInterface
{
    public function getFundsWithPreviewDigitalObject(): Collection;

    public function getFundsWithDigitalObject(Fund $fund, ?string $search = null): LengthAwarePaginator;
}
