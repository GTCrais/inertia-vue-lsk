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
- Mobile app support skeleton - versioned API, deep-linking email flows and FCM push notifications (see [Mobile app support](#mobile-app-support))

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
    - `MOBILE_APP_HEADER`, `MOBILE_APP_URI_SCHEME` and `MOBILE_APP_DEVICE_ID`, if you're going to be using the mobile app skeleton
    - `FIREBASE_CREDENTIALS`, if you're going to be using FCM push notifications
    - If you want to use Inertia SSR: 
        - `npm run build` (builds the SSR bundle as well)
        - `php artisan inertia:start-ssr`
    - If you want to use Laravel Horizon, just install it and uncomment `HorizonServiceProvider::class` in `bootstrap/providers.php`, and update the `gate()` method

- Start a queue worker - `php artisan queue:work`. Mail, broadcast and push notification jobs can be routed to dedicated queues via `QUEUE_MAIL`, `QUEUE_BROADCAST` and `QUEUE_PUSH_NOTIFICATIONS`

### Mobile app support
The kit ships with a skeleton for driving a companion mobile app:

- A versioned REST API mounted at `/api/mobile/v1` (`routes/mobile_v1.php`, registered in `app/Bootstrappers/RouteRegistrar.php`), authenticated with Sanctum bearer tokens
- Mobile app requests are recognized by a custom header (`MOBILE_APP_HEADER`). The `requestType:mobileApp` middleware hides the API (404) from callers without it, and the `mobileApp()`, `stateless()` and `mobileDeviceId()` request macros are available throughout the app
- Endpoints for app bootstrap data, registration, login/logout, auth checks, notifications (list + unread count), push notification token registration and account deletion
- Password reset and email verification resend reuse the web controllers, which respond with JSON when the request expects it
- Social sign in (Facebook, Google, Apple): the app opens `social-auth/{network}/oauth/redirect` in a browser, the OAuth callback deep-links back into the app, and the app exchanges the received token for a Sanctum token at `social-auth/exchange-token`
- Email deep-linking: verification and password reset emails sent for mobile app requests carry a `mobile=1` link parameter. Opened on a mobile device, the link serves an interstitial page that deep-links into the app via `MOBILE_APP_URI_SCHEME` (e.g. `yourapp://email-verified`) with a web fallback; opened on desktop, the regular web flow takes over
- Push notifications are sent through FCM (`FIREBASE_CREDENTIALS`), with devices tracked by a device id header (`MOBILE_APP_DEVICE_ID`) that also scopes the push endpoint rate limits
- Mobile-related configuration lives in `config/mobile.php`

### Things worth taking a look at
- `app/Bootstrappers`
- `app/Http/Middleware/SanctumMiddleware.php`
- `app/Http/Middleware/ThrottleSuccessfulRequests.php` - drop-in replacement for the `throttle` middleware that only counts successful requests towards the rate limit
- `app/Http/Middleware/EnsureMobileDeviceUniqueness.php` - keeps mobile device records unique per user; aliased as `ensureMobileDeviceUniqueness` but not attached to any route out of the box
- `app/Providers/StarterKitServiceProvider.php` - defines the `stateful()`, `stateless()` and `mobileApp()` request macros used throughout the auth flows
- `app/Providers/RateLimiterServiceProvider.php` - all of the named rate limiters used across the routes
- `app/Http/Helpers/AppResponse.php` - responds with an Inertia page for frontend requests and plain JSON for stateless ones
- `app/Services/InertiaHelperService.php` used in `app/Http/Middleware/HandleInertiaRequests.php`
- `app/Services/ViewMetadataProviderService.php`, used in `app/Services/InertiaHelperService.php`, `app/Http/Controllers/PageController.php` and `resources/views/default.blade.php`
- `resources/js/layouts/DefaultLayout.vue` - global `flash` event listener that turns Inertia flash data into toasts
- `resources/js/mixins/helper.js` - the `cn()` class-merging helper (clsx + tailwind-merge) used by the UI components

### License

`inertia-vue-lsk` Laravel Starter Kit is open-sourced software licensed under the [MIT license](LICENSE.md).
