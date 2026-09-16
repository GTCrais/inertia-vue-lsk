---
paths:
  - 'app/Notifications/**'
---

# Notifications

## Notifications are queued and send app Mailables
Queue every notification (`ShouldQueue` + `Queueable`) with explicit `$tries`, `$timeout` and `$failOnTimeout` plus a `backoff()` array, and route it through `viaQueues()` using `config('queue.map.<channel>')`. Build the email in `toMail()` by returning a Mailable from `app/Mail` (subject prefixed with the app name, content view under `mail/` extending `emailDefault`), not a `MailMessage`. Use the `SerializesWithAppUrl` trait so links generated in the worker keep the origin of the request that queued the notification.
