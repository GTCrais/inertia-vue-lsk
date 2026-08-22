## Inertia + Vue Laravel Starter Kit

### Tech stack: 
- Laravel (latest)
- Sanctum (latest)
- Inertia 3
- Vue 3
- Tailwind CSS 4

### Additional Composer packages
- Sanctum
- Socialite
- Apple Socialite Provider
- Intervention Image
- FCM notification channel
- Laravel Debugbar
- Predis

### Features
Out of the box this starter kit provides:
- Login and registration functionalities using conventional email + password method with email confirmation, as well as Sign in with Facebook and Google (Apple is supported server-side)
- Password reset functionality
- Email verification for both logged-in and guest users - logged-in users land back on their profile, guests get a confirmation page gated by a one-shot token
- User account area with profile editing (name + avatar upload with preview), password update and account deletion
- Toast notifications (vue-sonner) driven by Inertia flash data (`Inertia::flash()`) for one-time messages: email verified, password reset, expired session, rate limited
- Reusable UI components (`resources/js/components`): `AppButton` (renders an Inertia `Link` when given an `href`), `AppInput`, `AppLabel`, `Card`, modals
- Inertia SSR
- Graceful exceptions handling
- Skeleton for mobile app requests handling (although this needs a little more work)

### Requirements
- PHP >= 8.4
- Node.js >= 20  
- Redis (default driver for sessions, cache and queues)
- Laravel queues (for emails)

### Setup
- In `.env` fill out:
    - `APP_URL`
    - `GRACEFULLY_HANDLE_EXCEPTIONS` - boolean. If set to `true` you will get nice error pages instead of the default Inertia exception modal
    - `SESSION_DOMAIN`
    - `SANCTUM_STATEFUL_DOMAINS`
    - Mailgun credentials, unless you're using some other mailer
    - Facebook, Google and/or Apple credentials, if you're going to be using sign in with social networks feature
    - `MOBILE_APP_HEADER` and `MOBILE_APP_URI_SCHEME`, if you're going to be using the mobile app skeleton
    - `FIREBASE_CREDENTIALS`, if you're going to be using FCM push notifications
    - If you want to use Inertia SSR: 
        - `npm run build` (builds the SSR bundle as well)
        - `php artisan inertia:start-ssr`
    - If you want to use Laravel Horizon, just install it and uncomment `HorizonServiceProvider::class` in `bootstrap/providers.php`, and update the `gate()` method

- Start a queue worker - `php artisan queue:work`. Mail, broadcast and push notification jobs can be routed to dedicated queues via `QUEUE_MAIL`, `QUEUE_BROADCAST` and `QUEUE_PUSH_NOTIFICATIONS`

### Things worth taking a look at
- `app/Bootstrappers`
- `app/Http/Middleware/SanctumMiddleware.php`
- `app/Providers/StarterKitServiceProvider.php` - defines the `stateful()`, `stateless()` and `mobileApp()` request macros used throughout the auth flows
- `app/Services/InertiaHelperService.php` used in `app/Http/Middleware/HandleInertiaRequests.php`
- `app/Services/ViewMetadataProviderService.php`, used in `app/Services/InertiaHelperService.php`, `app/Http/Controllers/PageController.php` and `resources/views/default.blade.php`
- `resources/js/layouts/DefaultLayout.vue` - global `flash` event listener that turns Inertia flash data into toasts

### License

`inertia-vue-lsk` Laravel Starter Kit is open-sourced software licensed under the [MIT license](LICENSE.md).
