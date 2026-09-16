---
paths:
  - 'bootstrap/**'
---

# Bootstrap

## Application bootstrap is delegated to app/Bootstrappers
Keep bootstrap/app.php as a thin chain of `with*()` calls that each delegate to a static method on a class in `app/Bootstrappers` (RouteRegistrar, MiddlewareRegistrar, ExceptionsHandler, ScheduleRegistrar). Register middleware aliases, route files, exception handling and scheduled tasks there, never inline in bootstrap/app.php.
