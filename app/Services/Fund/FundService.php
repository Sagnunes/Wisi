<?php

declare(strict_types=1);

namespace App\Services\Fund;

use App\Contracts\Fund\FundRepositoryInterface;
use App\Contracts\Fund\FundServiceInterface;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class FundService implements FundServiceInterface
{
    public function __construct(private FundRepositoryInterface $repository) {}

    public function getFundsWithPreviewDigitalObject(): Collection
    {
        return $this->repository->findAllWithPreviewDigitalObject();
    }

    public function getFundsWithDigitalObject(Fund $fund, ?string $search = null): LengthAwarePaginator
    {
        return $this->repository->findWithDigitalObject($fund, $search);

    }
}
