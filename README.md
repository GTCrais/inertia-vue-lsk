## Inertia + Vue Laravel Starter Kit

### Tech stack: 
- Laravel (latest)
- Sanctum (latest)
- Inertia 2
- Vue 3
- Tailwind CSS 4

### Additional Composer packages
- Sanctum
- Socialite
- Apple Socialite Provider
- Laravel Debugbar
- Predis

### Features
Out of the box this starter kit provides:
- Login and registration functionalities using conventional email + password method with email confirmation, as well as Sign in with Facebook and Google
- Password reset functionality
- Inertia SSR
- Graceful exceptions handling
- Skeleton for mobile app requests handling (although this needs a little more work)

### Requirements
- PHP >= 8.4
- Node.js >= 20  
- Laravel queues (for emails)

### Setup
- In `.env` fill out:
    - `APP_URL`
    - `GRACEFULLY_HANDLE_EXCEPTIONS` - boolean. If set to `true` you will get nice error pages instead of the default Inertia exception modal
    - `SESSION_DOMAIN`
    - `SANCTUM_STATEFUL_DOMAINS`
    - Mailgun credentials, unless you're using some other mailer
    - Facebook and Google credentials, if you're going to be using sign in with social networks feature
    - If you want to use Inertia SSR: 
        - set `VITE_SSR` to `true`
        - `npm run build`
        - `php artisan inertia:start-ssr`
    - If you want to use Laravel Horizon, just install it and uncomment `HorizonServiceProvider::class` in `bootstrap/providers.php`, and update the `gate()` method

- Start the mail queue - `php artisan queue:work --queue=mail`

### Things worth taking a look at
- `app/Bootstrapers`
- `app/Http/Middleware/SanctumMiddleware.php`
- `app/Providers/StarterKitServiceProvider.php`
- `app/Services/InertiaHelperService.php` used in `app/Bootstrappers/ExceptionsHelper.php` and `app/Http/Middleware/HandlerInertiaRequests.php`
- `app/Services/ViewMetadataProviderService.php`, used in `app/Services/InertiaHelperService.php`, `app/Http/Controllers/PageController.php` and `resource/views/default.blade.php`

### License

`inertia-vue-lsk` Laravel Starter Kit is open-sourced software licensed under the [MIT license](LICENSE.md).


