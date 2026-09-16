---
paths:
  - 'app/Services/Auth/**'
---

# Auth

## Session auth always names the web guard
Call `auth()->guard('web')` explicitly for `attempt()`, `login()`, `logout()` and `user()` in session flows, because SanctumMiddleware switches the default guard to `sanctum` for mobile requests.
