<?php

declare(strict_types=1);

namespace App\Services\Fund;

use App\Contracts\Fund\FundRepositoryInterface;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class FundService
{
    public function __construct(private FundRepositoryInterface $repository) {}

    public function getAllFunds(): Collection
    {
        return $this->repository->all();
    }

    public function getFundsWithPreviewDigitalObject(): Collection
    {
        return $this->repository->findAllWithPreviewDigitalObject();
    }

    public function getFundsWithDigitalObject(Fund $fund, ?string $search = null): LengthAwarePaginator
    {
        return $this->repository->findWithDigitalObject($fund, $search);

    }
}
