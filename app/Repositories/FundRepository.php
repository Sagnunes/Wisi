<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\FundRepositoryInterface;
use App\Models\DigitalObject;
use App\Models\Fund;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final readonly class FundRepository implements FundRepositoryInterface
{
    /**
     *  Columns to select from the fund table
     */
    private const FUND_COLUMNS = [
        'id',
        'name',
        'acronym',
    ];

    public function __construct(private Fund $model) {}

    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function findAllWithPreviewDigitalObject(): Collection
    {
        return Cache::remember('funds', 60, fn () => $this->baseQuery()->with(['digitalObjects' => function ($query): void {
            $query->select('fund_id', 'image_thumb', 'image_name', 'id')
                ->whereNotNull('image_thumb')
                ->limit(1);
        }])->orderBy('acronym')->get());
    }

    public function findWithDigitalObject(Fund $fund, ?string $search = null): LengthAwarePaginator
    {
        return DigitalObject::with('fund', 'status')
            ->where('fund_id', $fund->id)
            ->where(function ($query) use ($search): void {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('inventory_number', 'LIKE', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate()
            ->withQueryString();
    }

    private function baseQuery(): Builder
    {
        return $this->model->query()->select(self::FUND_COLUMNS)->orderBy('acronym');
    }
}
