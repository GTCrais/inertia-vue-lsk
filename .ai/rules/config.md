---
paths:
  - 'config/**'
---

# Config

## camelCase for app-defined keys, kebab-case dotted route names
Use camelCase for keys the app defines: config keys in app-specific files (`mobile.deviceIdHeader`), rate limiter names, middleware aliases (`throttleSuccessfulRequests`), session and Inertia flash keys, and Inertia props. Keys added to Laravel's own config files stay snake_case (`app.gracefully_handle_exceptions`, `queue.map.push_notifications`). Name routes as kebab-case subject plus dotted verb (`password-reset-request.store`, `social-auth.exchange-token`).
