<?php

use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Auth\EmailVerificationConfirmationController;
use App\Http\Controllers\Auth\LoginPageController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetRequestController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\RegistrationPageController;
use App\Http\Controllers\Auth\SocialAuthSessionController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:sanctum'])->group(function () {
	Route::get('/login', [LoginPageController::class, 'show'])->name('login.show');
	Route::middleware(['throttle:login'])->post('/login', [AuthSessionController::class, 'store'])->name('auth-session.store');
	Route::post('/login/{socialNetwork}', [SocialAuthSessionController::class, 'store'])->where('socialNetwork', 'facebook|google|apple')->name('social-auth-session.store');
	Route::get('/register', [RegistrationPageController::class, 'show'])->name('registration.show');
	Route::middleware(['throttle:register'])->post('/register', [RegisteredUserController::class, 'store'])->name('registration.store');
	Route::get('/email-verified', EmailVerificationConfirmationController::class)->name('email-verified.show');
	Route::get('/forgot-password', [PasswordResetRequestController::class, 'create'])->name('password-reset-request.create');
	Route::middleware(['throttle:passwordReset'])->post('/forgot-password', [PasswordResetRequestController::class, 'store'])->name('password-reset-request.store');
	Route::get('/new-password', [NewPasswordController::class, 'create'])->name('new-password.create');
	Route::post('/new-password', [NewPasswordController::class, 'store'])->name('new-password.store');
});

Route::middleware(['signed', 'throttle:emailVerification'])->get('/email/verify/{id}/{hash}', VerifyEmailController::class)->name('verify-email.show');

Route::middleware(['auth:sanctum'])->group(function () {
	Route::get('/account', [PageController::class, 'show'])->name('user-account.show');
	Route::post('/logout', [AuthSessionController::class, 'destroy'])->name('auth-session.destroy');
});

Route::get('/{slug?}', [PageController::class, 'show'])->where('slug', '.*')->name('pages.show');
