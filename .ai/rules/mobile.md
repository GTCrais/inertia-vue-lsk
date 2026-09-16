---
paths:
  - 'app/Http/Controllers/Mobile/**'
---

# Mobile

## Mobile endpoints return response()->json() with plain data; resources are unwrapped
Return `response()->json($arrayOrModel)` directly from mobile controllers, and a bare `response()->json()` for an empty success. API Resources exist only for the User and Notification payloads and are never wrapped in a `data` key; wrapping is disabled globally in AppServiceProvider.
