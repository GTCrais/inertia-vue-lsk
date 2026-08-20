<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
	Route::get('/account', [PageController::class, 'show'])->name('user-account.show');
});

Route::get('/{slug?}', [PageController::class, 'show'])->where('slug', '.*')->name('pages.show');
