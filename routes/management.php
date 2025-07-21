<?php

declare(strict_types=1);

use App\Http\Controllers\Permissions\PermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('gestao-utilizadores')->group(function () {
    Route::prefix('permissoes')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');

        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');

        Route::patch('/{permission:uuid}', [PermissionController::class, 'update'])->name('permissions.update');

        Route::delete('/{permission:uuid}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

        Route::get('/{permission:uuid}/editar', [PermissionController::class, 'edit'])->name('permissions.edit');

    });
});
