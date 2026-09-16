---
paths:
  - 'app/Http/Requests/**'
---

# Requests

## Validate through Form Requests named subject-first
Every endpoint that accepts input validates through a Form Request in `app/Http/Requests` (subfolder per area such as `Requests/Auth`); no inline `$request->validate()` or `Validator::make()` in controllers. Name requests after the controller subject then the action (`ProfileUpdateRequest`, `NewPasswordStoreRequest`), not `StoreXRequest`; a request for a single-action controller mirrors the controller name (`VerifyEmailRequest`). Merge header-derived input in `prepareForValidation()` so normal rules can validate it.
