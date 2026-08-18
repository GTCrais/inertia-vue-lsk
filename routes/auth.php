<?php

use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Auth\EmailVerificationConfirmationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetRequestController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SocialAuthSessionController;
use App\Http\Controllers\Auth\UsernameValidityController;
use App\Http\Controllers\Auth\UsernameController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::middleware(['guest:sanctum'])->group(function () {
	Route::middleware(['throttle:login'])->post('/login', [AuthSessionController::class, 'store'])->name('auth-session.store');
	Route::middleware(['throttle:socialLogin'])->post('/login/{socialNetwork}', [SocialAuthSessionController::class, 'store'])->where('socialNetwork', 'facebook|google|apple')->name('social-auth-session.store');
	Route::middleware(['throttle:register'])->post('/register', [RegisteredUserController::class, 'store'])->name('registration.store');
	Route::get('/email-verificiran', EmailVerificationConfirmationController::class)->name('email-verified.show');
	Route::get('/zaboravljena-lozinka', [PasswordResetRequestController::class, 'create'])->name('password-reset-request.create');
	Route::middleware(['throttle:passwordReset'])->post('/forgot-password', [PasswordResetRequestController::class, 'store'])->name('password-reset-request.store');
	Route::get('/nova-lozinka', [NewPasswordController::class, 'create'])->name('new-password.create');
	Route::post('/new-password', [NewPasswordController::class, 'store'])->name('new-password.store');
});

Route::middleware(['signed', 'throttle:emailVerification'])->get('/email/verificiraj/{id}/{hash}', VerifyEmailController::class)->name('verify-email.show');

Route::middleware(['auth:sanctum'])->group(function () {
	Route::middleware(['throttleSuccessfulRequests:emailVerificationNotification'])->post('/email-verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('email-verification-notification.store');
	Route::post('/logout', [AuthSessionController::class, 'destroy'])->name('auth-session.destroy');
});