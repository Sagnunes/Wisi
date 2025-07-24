<?php

declare(strict_types=1);

use App\Http\Controllers\Funds\FundController;
use App\Http\Controllers\Funds\FundInquiryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('colecao-digital/inquerito', FundInquiryController::class)->name('funds.inquiry');
    Route::get('colecao-digital', [FundController::class, 'index'])->name('funds.index');
    Route::get('colecao-digital/{fund:acronym}', [FundController::class, 'show'])->name('funds.show');
});
