<?php

declare(strict_types=1);

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Services\Fund\FundService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

final class ShowDigitalObjectsByFundController extends Controller
{
    public function __construct(private readonly FundService $service) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Fund $fund)
    {
        $search = Request::input('search');

        $fundResourcesPagination = $this->service->getFundsWithDigitalObject($fund, $search);

        return Inertia::render('Funds/Show', [
            'fund' => $fund,
            'collections' => Inertia::merge($fundResourcesPagination->items()),
            'pagination' => Arr::except($fundResourcesPagination->toArray(), ['data']),
        ]);
    }
}
