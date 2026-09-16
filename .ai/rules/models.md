---
paths:
  - 'app/Models/**'
---

# Models

## Morph map is enforced; register every polymorphic model
AppServiceProvider enforces a morph map (`Relation::enforceMorphMap`), currently `user` => User. Any model that takes part in a polymorphic relation (notifiable, tokenable, or a new morph) must be added to that map with a short snake_case alias, or the relation throws.
