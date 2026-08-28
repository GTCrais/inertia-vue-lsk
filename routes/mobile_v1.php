<?php

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetRequestController;
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

	Route::post('/auth/check', MobileAuthCheckController::class)->name('auth.check');
	Route::post('/auth/user', MobileAuthUserController::class)->name('auth.user');

	Route::middleware(['throttle:socialTokenExchange'])->post('/social-auth/exchange-token', MobileSocialAuthExchangeTokenController::class)->name('social-auth.exchange-token');

	Route::middleware(['guest:sanctum'])->group(function () {
		Route::middleware(['throttle:login'])->post('/login', [MobileAuthSessionController::class, 'store'])->name('auth.store');
		Route::middleware(['throttle:register'])->post('/register', [MobileRegisteredUserController::class, 'store'])->name('registration.store');

		// Shared controllers (auth.php)
		Route::middleware(['throttle:passwordReset'])->post('/forgot-password', [PasswordResetRequestController::class, 'store'])->name('password-reset-request.store');
		Route::middleware(['throttle:newPassword'])->post('/new-password', [NewPasswordController::class, 'store'])->name('new-password.store');
	});

	Route::middleware(['auth:sanctum'])->group(function () {
		Route::post('/logout', [MobileAuthSessionController::class, 'destroy'])->name('auth.destroy');
		Route::get('/notifications', [MobileNotificationController::class, 'index'])->name('notification.index');
		Route::get('/notifications/count', MobileNotificationCountController::class)->name('notification.count');
		Route::middleware(['throttle:pushNotificationsTokenStore'])->post('/push-notifications-token', [MobilePushNotificationTokenController::class, 'store'])->name('push-notifications-token.store');
		Route::middleware(['throttle:pushNotificationsTokenDestroy'])->delete('/push-notifications-token', [MobilePushNotificationTokenController::class, 'destroy'])->name('push-notifications-token.destroy');
		Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');

		// Shared controllers (auth.php)
		Route::middleware(['throttleSuccessfulRequests:emailVerificationNotification'])->post('/email-verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('email-verification-notification.store');
	});
});

// Not wrappable — reached from an external browser context (OAuth redirects)
Route::prefix('social-auth/{socialNetwork}/oauth')
	->where(['socialNetwork' => 'facebook|google|apple'])
	->group(function () {
		Route::get('/redirect', MobileSocialAuthRedirectController::class)->name('social-auth.redirect');
		Route::match(['get', 'post'], '/callback', MobileSocialAuthCallbackController::class)->name('social-auth.callback');
	});
