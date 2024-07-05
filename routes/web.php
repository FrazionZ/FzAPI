<?php

use App\Http\Controllers\UpdaterController;
use Illuminate\Support\Facades\Route;

Route::get('/oue', function () {
    return response()->json([]);
});

Route::name('updater.')->prefix('updater')->group(function () {
    Route::get('/oue', function () {
        return response()->json([]);
    });
    Route::get('/check/{target}/{arch}/{current_version}', [UpdaterController::class, 'check'])->name('check');
});
