---
paths:
  - 'resources/js/pages/**'
---

# Pages

## Page titles and meta are set on the server, not with <Head>
Do not use Inertia `<Head>` in pages. Set the title with `ViewMetadataProviderService::setTitle()` in the controller; it reaches the client as the shared `metadata` prop and is rendered once by AppHead inside DefaultLayout.

## DefaultLayout is applied globally; pages don't declare it
Do not import or set DefaultLayout on pages; it is applied in the Inertia app config. For a page inside a nested layout, set `layout: [DefaultLayout, NestedLayout]` on the page options.
