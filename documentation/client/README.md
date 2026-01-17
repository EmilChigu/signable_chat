# Client Documentation

# Signable Chat – Client

Vue 3 + TypeScript frontend rendered through Inertia. Pages live in `resources/js/pages`.

## Entry Points
- `resources/js/app.ts` bootstraps Inertia, registers Vue plugins/components, and loads global CSS.

## Pages
| Component | Path | Purpose |
| --- | --- | --- |
| `Welcome.vue` | `resources/js/pages/Welcome.vue` | Username capture form rendered at `/`. |
| `ChatRoom.vue` | `resources/js/pages/ChatRoom.vue` | Chat timeline and composer rendered at `/chat`. |