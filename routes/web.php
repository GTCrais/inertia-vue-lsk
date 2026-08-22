<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\User\PasswordController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
	Route::prefix('user')
		->name('user.')
		->group(function() {
			Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
			Route::middleware(['throttleSuccessfulRequests:profileUpdate'])->post('/profile', [ProfileController::class, 'update'])->name('profile.update');
			Route::get('/password', [PasswordController::class, 'show'])->name('password.show');
			Route::middleware(['throttleSuccessfulRequests:passwordUpdate'])->put('/password', [PasswordController::class, 'update'])->name('password.update');
			Route::delete('/', [UserController::class, 'destroy'])->name('destroy');
		});
});

Route::get('/{slug?}', [PageController::class, 'show'])->where('slug', '.*')->name('pages.show');
