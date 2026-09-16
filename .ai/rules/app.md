---
paths:
  - 'app/**'
---

# App

## Traits live in a Concerns subfolder of the layer they serve
Put a trait in the `Concerns` namespace beside the classes that use it (`App\Http\Concerns`, `App\Http\Controllers\Concerns`, `App\Models\Concerns`, `App\Notifications\Concerns`). Do not create `app/Traits`.

## Detect the client through the Request macros
Use the macros defined in RequestMacroServiceProvider to tell clients apart: `$request->mobileApp()`, `stateful()`, `stateless()` and `mobileDeviceId()`. Never read the mobile or device-id headers or the from_frontend flag directly; add new client-detection logic as another macro there.

## Inject with protected promoted constructor properties
Declare dependencies as promoted constructor properties with `protected` visibility (`public function __construct(protected AuthService $authService) {}`), not `private`, `public` or `readonly`. Use `resolve(Foo::class)` sparingly, inside traits and closures; never `app()->make()`.

## camelCase for app-defined keys, kebab-case dotted route names
Use camelCase for keys the app defines: config keys in app-specific files (`mobile.deviceIdHeader`), rate limiter names, middleware aliases (`throttleSuccessfulRequests`), session and Inertia flash keys, and Inertia props. Keys added to Laravel's own config files stay snake_case (`app.gracefully_handle_exceptions`, `queue.map.push_notifications`). Name routes as kebab-case subject plus dotted verb (`password-reset-request.store`, `social-auth.exchange-token`).

## Signal HTTP errors with abort()
Fail a request with `abort(status, 'message')`: 401 for bad credentials or tokens, 404 for the wrong client type, 422 for a missing device header. There are no custom exception classes; throw only framework exceptions such as ValidationException when a custom response is needed.
