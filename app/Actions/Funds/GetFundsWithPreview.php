<?php

declare(strict_types=1);

namespace App\Actions\Funds;

use App\Contracts\Services\FundServiceInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class GetFundsWithPreview
{
    public function __construct(private FundServiceInterface $service) {}

    public function handle(): Collection
    {
        return $this->service->getFundsWithPreviewDigitalObject();
    }
}
