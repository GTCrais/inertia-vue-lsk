<?php

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetRequestController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Mobile\V1\MobileAppDataController;
use App\Http\Controllers\Mobile\V1\MobileAuthCheckController;
use App\Http\Controllers\Mobile\V1\MobileAuthSessionController;
use App\Http\Controllers\Mobile\V1\MobileAuthUserController;
use App\Http\Controllers\Mobile\V1\MobilePushNotificationTokenController;
use App\Http\Controllers\Mobile\V1\MobileNotificationController;
use App\Http\Controllers\Mobile\V1\MobileNotificationCountController;
use App\Http\Controllers\Mobile\V1\MobileRegisteredUserController;
use App\Http\Controllers\Mobile\V1\MobileSocialAuthCallbackController;
use App\Http\Controllers\Mobile\V1\MobileSocialAuthExchangeTokenController;
use App\Http\Controllers\Mobile\V1\MobileSocialAuthRedirectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('requestType:mobileApp')->group(function () {
	Route::get('/app-data', MobileAppDataController::class)->name('app-data');
	Route::get('/notifications', [MobileNotificationController::class, 'index'])->name('notification.index');
	Route::get('/notifications/count', MobileNotificationCountController::class)->name('notification.count');

	Route::post('/auth/check', MobileAuthCheckController::class)->name('auth.check');
	Route::post('/auth/user', MobileAuthUserController::class)->name('auth.user');

	Route::middleware(['guest:sanctum'])->group(function () {
		Route::post('/login', [MobileAuthSessionController::class, 'store'])->name('auth.store');
		Route::middleware(['throttle:register'])->post('/register', [MobileRegisteredUserController::class, 'store'])->name('registration.store');
	});

	Route::middleware(['auth:sanctum'])->group(function () {
		Route::post('/logout', [MobileAuthSessionController::class, 'destroy'])->name('auth.destroy');
	});

	Route::post('/social-auth/exchange-token', MobileSocialAuthExchangeTokenController::class)->name('social-auth.exchange-token');

	Route::middleware(['throttle:pushNotificationsTokenStore'])->post('/push-notifications-token', [MobilePushNotificationTokenController::class, 'store'])->name('push-notifications-token.store');
	Route::middleware(['throttle:pushNotificationsTokenDestroy'])->delete('/push-notifications-token', [MobilePushNotificationTokenController::class, 'destroy'])->name('push-notifications-token.destroy');

	Route::middleware(['auth:sanctum'])
		->prefix('user')
		->name('user.')
		->group(function () {
			Route::delete('/', [UserController::class, 'destroy'])->name('user.destroy');
		});

	// Shared controllers (auth.php)
	Route::middleware(['guest:sanctum'])->group(function () {
		Route::middleware(['throttle:passwordReset'])->post('/forgot-password', [PasswordResetRequestController::class, 'store'])->name('password-reset-request.store');
		Route::post('/new-password', [NewPasswordController::class, 'store'])->name('new-password.store');
	});

	Route::middleware(['auth:sanctum'])->group(function () {
		Route::middleware(['throttleSuccessfulRequests:emailVerificationNotification'])->post('/email-verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('email-verification-notification.store');
	});
});

// Not wrappable — reached from an external browser context (OAuth redirects, email link click)
Route::prefix('social-auth/{socialNetwork}/oauth')
	->where(['socialNetwork' => 'facebook|google|apple'])
	->group(function () {
		Route::middleware('useUrlVisitorUuid')->get('/redirect', MobileSocialAuthRedirectController::class)->name('social-auth.redirect');
		Route::match(['get', 'post'], '/callback', MobileSocialAuthCallbackController::class)->name('social-auth.callback');
	});

Route::middleware(['signed', 'throttle:emailVerification'])->get('/email/verify/{id}/{hash}', VerifyEmailController::class)->name('verify-email.show');
