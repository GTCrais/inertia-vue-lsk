---
paths:
  - 'routes/**'
---

# Routes

## Mobile API is versioned under Mobile/V{n} and shares web controllers via wantsJson()
Mobile-only endpoints go in `App\Http\Controllers\Mobile\V{n}` with a `Mobile` class prefix and routes in `routes/mobile_v{n}.php`, registered in RouteRegistrar under the `api/mobile/v{n}` prefix and `api.mobile.v{n}.` name prefix. When web and mobile need the same behaviour, reuse the web controller from the mobile routes file and branch on `$request->wantsJson()`: JSON for mobile, `back()` or a redirect for Inertia.

## Resource-verb controllers with explicit named routes, invokables for single actions
One controller per subject with resource verb methods (`show`, `create`, `store`, `update`, `destroy`, `index`) even for non-CRUD concepts: login is `AuthSessionController@store`, logout is `@destroy`, resending the verification mail is `EmailVerificationNotificationController@store`. Use an invokable controller when an endpoint has a single action. Declare each route explicitly with its verb and a name; never `Route::resource`.

## Middleware is declared at the start of the route definition
Attach middleware as the leading call, `Route::middleware(['throttle:login'])->post('/login', ...)`, not as a trailing `->middleware()` on the route. Controllers do not implement `HasMiddleware` or use middleware attributes; groups and aliases handle everything.

## Every mutating endpoint gets a named limiter from RateLimiterService
Throttle each state-changing route with a named limiter registered in `RateLimiterService::registerLimiters()` (camelCase name, `Limit::perMinute(n)->by(...)`) and referenced as `throttle:{name}`; never inline `throttle:60,1`. For authenticated form submissions use the `throttleSuccessfulRequests:{name}` alias so only successful requests count.

## camelCase for app-defined keys, kebab-case dotted route names
Use camelCase for keys the app defines: config keys in app-specific files (`mobile.deviceIdHeader`), rate limiter names, middleware aliases (`throttleSuccessfulRequests`), session and Inertia flash keys, and Inertia props. Keys added to Laravel's own config files stay snake_case (`app.gracefully_handle_exceptions`, `queue.map.push_notifications`). Name routes as kebab-case subject plus dotted verb (`password-reset-request.store`, `social-auth.exchange-token`).
