---
paths:
  - 'resources/js/components/**'
---

# Components

## Merge caller classes with cn() through a class prop
Style with inline Tailwind utilities only, no `@apply` or `<style>` blocks. A component that accepts extra classes declares `class` as a prop, exposes it as the `receivedClass` computed, mixes in the Helper mixin, and applies `:class="cn('base…', receivedClass)"` on its root.
