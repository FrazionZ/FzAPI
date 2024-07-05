<?php

use App\Http\Controllers\UpdaterController;
use Illuminate\Support\Facades\Route;

Route::name('updater.')->prefix('updater')->group(function () {
    Route::get('/check/{target}/{arch}/{current_version}', [UpdaterController::class, 'check'])->name('check');
});
