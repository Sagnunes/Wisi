<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('colecao-digital', App\Http\Controllers\Funds\IndexFundController::class)->name('funds.index');
    Route::get('colecao-digital/{fund:acronym}', App\Http\Controllers\Funds\ShowDigitalObjectsByFundController::class)->name('funds.show');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
