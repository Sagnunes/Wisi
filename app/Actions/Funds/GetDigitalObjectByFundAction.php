<?php

declare(strict_types=1);

namespace App\Actions\Funds;

use App\Contracts\Fund\FundServiceInterface;
use App\Models\Fund;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class GetDigitalObjectByFundAction
{
    public function __construct(private FundServiceInterface $service) {}

    public function handle(Fund $fund, ?string $search): LengthAwarePaginator
    {
        return $this->service->getFundsWithDigitalObject($fund, $search);
    }
}
