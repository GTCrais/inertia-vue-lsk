---
paths:
  - 'app/Services/**'
---

# Services

## Business logic lives in Services; controllers only orchestrate
Put logic in `App\Services\{Subject}Service` classes (grouped in a domain subfolder such as `Services/Auth` when related) with descriptive verb methods, and pass the Form Request or Request object straight into the service. Keep controllers to: resolve the service, call it, shape the response. There are no Actions, DTOs, repositories, query objects or app-level events; services query Eloquent directly.

## Every mutating endpoint gets a named limiter from RateLimiterService
Throttle each state-changing route with a named limiter registered in `RateLimiterService::registerLimiters()` (camelCase name, `Limit::perMinute(n)->by(...)`) and referenced as `throttle:{name}`; never inline `throttle:60,1`. For authenticated form submissions use the `throttleSuccessfulRequests:{name}` alias so only successful requests count.

## Wrap creates and multi-statement writes in DB::transaction()
Wrap model creation and any write sequence of more than one statement in `DB::transaction()` with a closure; never `beginTransaction()`/`commit()`. Single-statement updates and deletes run unwrapped.
