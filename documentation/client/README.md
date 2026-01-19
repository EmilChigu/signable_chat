# Client Documentation

# Signable Chat – Client

Vue 3 + TypeScript frontend rendered through Inertia. Source lives under `resources/js` and is built with Vite.

## Stack & Tooling
- Vite 5 with `laravel-vite-plugin`, `@laravel/vite-plugin-wayfinder`, and Tailwind CSS integration.
- Vue 3 rendered via Inertia (`@inertiajs/vue3`).
- Vitest + Vue Test Utils for unit/component tests, configured through `vitest.config.ts`.

## Entry Points
- `resources/js/app.ts` bootstraps Inertia, installs plugins, registers layout components, and loads `resources/css/app.css`.

## Directory Overview
| Path | Purpose                           |
| --- |-----------------------------------|
| `resources/js/pages` | Pages rendered by laravel         |
| `resources/js/components` | UI pieces                         |
| `resources/js/tests` | vitest tests 


## Pages
| Component | Path | Purpose |
| --- | --- | --- |
| `Welcome.vue` | `resources/js/pages/Welcome.vue` | Username capture form rendered at `/`. |
| `ChatRoom.vue` | `resources/js/pages/ChatRoom.vue` | Chat timeline and composer rendered at `/chat`. |

## Core Components
| Component | Path | Notes |
| --- | --- | --- |
| `ChatBubbleComponent.vue` | `resources/js/components/chat/ChatBubbleComponent.vue` | Renders a single chat message, highlights sender metadata, and formats `dateSent`. |
| `ChatFormComponent.vue` | `resources/js/components/chat/ChatFormComponent.vue` | Composer textarea that posts messages to `/chat` via `useForm`, emits `sent` when successful. |

## Data & Validation Flow
1. `Welcome.vue` stores the visitor’s username using `router.post('/')`; validation errors arrive via Inertia props and render inline.
2. Upon success, the backend redirects to `/chat`, which renders `ChatRoom.vue` with paginated messages.
3. `ChatFormComponent.vue` maintains local state with `useForm`, validates simple length rules, and posts to `/chat`. On success it resets and emits `sent` so the parent can refresh the timeline.
4. Components rely on the `@` alias (e.g., `@/components/chat/ChatFormComponent.vue`) for concise imports.

## Styling & Assets
- Tailwind is used to styles all components

## Testing
| Suite | Path | Coverage |
| --- | --- | --- |
| Chat bubble specs | `resources/js/tests/chat_bubble.test.ts` | Verifies message rendering, sender visibility, and timestamp formatting. |
| Chat form specs | `resources/js/tests/chat_form.test.ts` | Covers validation state, error rendering, and successful submissions/emits. |
| Welcome page specs | `resources/js/tests/welcome.test.ts` | Ensures username validation, error display, and Inertia submission logic. |

Run the entire client test suite:
```bash
cd /Users/emilchigu/Desktop/Dev/signable_chat
npm run test
```

## Development Scripts
```bash
npm install       # install client dependencies
npm run dev       # start Vite + Laravel hot reload
npm run test      # execute Vitest with coverage
```

## Future Improvements
- Add real validation with VeeValidate + Yup so both forms go beyond length checks and provide better UX.
- Swap the polling workflow for Laravel Echo/websockets so new messages arrive instantly without refresh.
- Sanitize incoming/outgoing strings and strip special characters before rendering to avoid layout glitches or XSS vectors.
- Expand Vitest coverage (pages, utilities, composables) to reduce the number of uncovered files in reports.
- Auto-scroll the chat timeline whenever a message arrives or the form emits `sent`.
- Break oversized pages (`ChatRoom.vue`) into smaller focused components for readability and reuse.
- Extract shared interfaces and helper functions into dedicated files (`resources/js/interfaces`, `resources/js/lib/utils.ts`) to keep SFCs lightweight.
- Replace simple ref state with Pinia store to centralize session/user/chat state.
- Add sentry error tracking.