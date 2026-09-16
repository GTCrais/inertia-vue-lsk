---
paths:
  - 'app/Http/Controllers/**'
---

# Controllers

## Business logic lives in Services; controllers only orchestrate
Put logic in `App\Services\{Subject}Service` classes (grouped in a domain subfolder such as `Services/Auth` when related) with descriptive verb methods, and pass the Form Request or Request object straight into the service. Keep controllers to: resolve the service, call it, shape the response. There are no Actions, DTOs, repositories, query objects or app-level events; services query Eloquent directly.

## Mobile API is versioned under Mobile/V{n} and shares web controllers via wantsJson()
Mobile-only endpoints go in `App\Http\Controllers\Mobile\V{n}` with a `Mobile` class prefix and routes in `routes/mobile_v{n}.php`, registered in RouteRegistrar under the `api/mobile/v{n}` prefix and `api.mobile.v{n}.` name prefix. When web and mobile need the same behaviour, reuse the web controller from the mobile routes file and branch on `$request->wantsJson()`: JSON for mobile, `back()` or a redirect for Inertia.

## Validate through Form Requests named subject-first
Every endpoint that accepts input validates through a Form Request in `app/Http/Requests` (subfolder per area such as `Requests/Auth`); no inline `$request->validate()` or `Validator::make()` in controllers. Name requests after the controller subject then the action (`ProfileUpdateRequest`, `NewPasswordStoreRequest`), not `StoreXRequest`; a request for a single-action controller mirrors the controller name (`VerifyEmailRequest`). Merge header-derived input in `prepareForValidation()` so normal rules can validate it.

## Resource-verb controllers with explicit named routes, invokables for single actions
One controller per subject with resource verb methods (`show`, `create`, `store`, `update`, `destroy`, `index`) even for non-CRUD concepts: login is `AuthSessionController@store`, logout is `@destroy`, resending the verification mail is `EmailVerificationNotificationController@store`. Use an invokable controller when an endpoint has a single action. Declare each route explicitly with its verb and a name; never `Route::resource`.

## One-shot UI flags use Inertia::flash(); page messages ride the session
Signal a one-time outcome with `Inertia::flash('flagName', true)` before redirecting; DefaultLayout turns known flags into toasts. For a message a specific page must display, flash it with `back()->with('key', $message)` and read it back with `session('key')` into an explicit prop in the GET action. Do not share a generic `flash` array from HandleInertiaRequests.

## Page titles and meta are set on the server, not with <Head>
Do not use Inertia `<Head>` in pages. Set the title with `ViewMetadataProviderService::setTitle()` in the controller; it reaches the client as the shared `metadata` prop and is rendered once by AppHead inside DefaultLayout.
