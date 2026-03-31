<?php

use Illuminate\Support\Facades\Route;
use Adeel3330\InsightGuard\Controllers\DashboardController;

Route::prefix('insightguard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('insightguard.dashboard');
    Route::get('/export/pdf', [DashboardController::class, 'exportPdf'])->name('insightguard.export.pdf');
    Route::get('/export/json', [DashboardController::class, 'exportJson'])->name('insightguard.export.json');
});

Route::get('/insight-guard', function () {
    return view('insightguard::dashboard');
});