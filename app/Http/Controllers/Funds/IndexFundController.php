<?php

declare(strict_types=1);

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use App\Services\Fund\FundService;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class IndexFundController extends Controller
{
    public function __construct(private readonly FundService $service) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Inertia\Response
    {
        $funds = $this->service->getFundsWithPreviewDigitalObject();

        return Inertia::render('Funds/Index', ['funds' => $funds]);
    }
}
