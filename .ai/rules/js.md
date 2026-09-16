---
paths:
  - 'resources/js/**'
---

# Js

## Vue SFCs use the Options API in plain JavaScript
Write every component and page as an Options API SFC in plain JavaScript (`export default { components, props, data(), methods, computed }`), template block first; no `<script setup>`, Composition API or TypeScript. Put shared behaviour in Options-API mixins in the mixins folder, not composables.

## Import through the `@/js/` alias and register components locally
The `@` alias points at `resources`, so import app code as `@/js/components/Card.vue`, never `@/components/...`. Register components locally in `components: {}` and use them as kebab-case tags; `<app-link>` is the globally registered Inertia Link.

## Hardcode URL paths; no Ziggy or route() on the client
Write links and request URLs as literal paths (`href="/user/profile"`, `form.post('/login')`). There is no Ziggy, Wayfinder or client `route()` helper, so do not add one or pass route names as props.

## Forms use Inertia useForm in data(); other actions use router.*
Build forms with `useForm()` assigned in `data()`, return early on `form.processing`, call `clearErrors()`, submit with `form.post('/path', { preserveScroll: true })`, and show `form.errors.<field>` inline under each input. Fire non-form actions with `router.post/put/delete` plus `onSuccess`/`onError`/`onFinish` callbacks and a local boolean guard; do not reach for the axios instance or `useHttp` for Inertia-handled requests.

## Toasts via vue-sonner; server flash keys are mapped in DefaultLayout
Show feedback with `toast.success/warning/error()` from vue-sonner after client actions; the single `<Toaster>` lives in DefaultLayout. Server outcomes arrive as boolean Inertia flash keys and are turned into toasts by the `router.on('flash')` listener in DefaultLayout, so add new keys there, not in pages.

## SSR is on; guard browser-only code with $isBrowser
The app ships an SSR bundle, so never touch `window`/`document` at module scope, in `data()` or in `created()` without checking `this.$isBrowser`; `mounted()` is browser-only and safe.

## UI primitives: @lucide/vue icons, Headless UI dialogs via AppModal
Use icons from `@lucide/vue`, registered locally, wrapped in `markRaw()` when stored in `data()` for `:is`. Build dialogs on AppModal, which wraps Headless UI Dialog/Transition.
