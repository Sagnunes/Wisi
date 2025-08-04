<?php

declare(strict_types=1);

namespace App\Http\Controllers\Funds;

use App\Actions\Funds\GetDigitalObjectByFund;
use App\Actions\Funds\GetFundsWithPreview;
use App\Http\Controllers\Controller;
use App\Models\Fund;
use Illuminate\Support\Arr;
use Inertia\Inertia;

final class FundController extends Controller
{
    public function index(GetFundsWithPreview $action): \Inertia\Response
    {
        $funds = $action->handle();

        return Inertia::render('Funds/Index', ['funds' => $funds]);
    }

    public function show(Fund $fund, GetDigitalObjectByFund $action): \Inertia\Response
    {
        $search = \Illuminate\Support\Facades\Request::input('search');

        $fundWithDigitalObjectAndPagination = $action->handle($fund, $search);

        return Inertia::render('Funds/Show', [
            'fund' => $fund,
            'collections' => Inertia::merge($fundWithDigitalObjectAndPagination->items()),
            'pagination' => Arr::except($fundWithDigitalObjectAndPagination->toArray(), ['data']),
        ]);
    }
}
