<?php

use Illuminate\Support\Facades\Route;
use Adeel3330\InsightGuard\Dashboard\Controllers\InsightDashboardController;

Route::prefix('insightguard')->group(function () {
    Route::get('/', [InsightDashboardController::class, 'index'])->name('insightguard.dashboard');
    Route::get('/export/pdf', [InsightDashboardController::class, 'exportPdf'])->name('insightguard.export.pdf');
    Route::get('/export/json', [InsightDashboardController::class, 'exportJson'])->name('insightguard.export.json');
});

