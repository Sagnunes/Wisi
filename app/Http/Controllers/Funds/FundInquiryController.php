<?php

declare(strict_types=1);

namespace App\Http\Controllers\Funds;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class FundInquiryController extends Controller
{
    /**inquiry
     * Handle the incoming request.
     */
    public function __invoke(): \Inertia\Response
    {
        return Inertia::render('Funds/Inquiry');
    }
}
