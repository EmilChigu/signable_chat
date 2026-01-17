# Backend Documentation

# Signable Chat – Backend

Laravel 12 + Sail backend that exposes a minimal session-gated chat API and renders Inertia components.

## Stack & Tooling
- Laravel Sail (Dockerized runtime) with PHP 8.5.1
- Inertia.js server adapter
- SQLite by default (`database/database.sqlite`) but configurable via `.env`

## Domain Model
| Model | Fields | Notes |
| --- | --- | --- |
| `ChatMessage` | `username`, `message` | Fillable, timestamps enabled, defined in `app/Models/ChatMessage.php`.

Migration: `database/migrations/2026_01_17_170556_create_chat_messages_table.php` creates the table.

## Session Flow
1. Visitor opens `/` and is presented with the username form (`JoinTeamChatController@index`).
2. Posting a username (`JoinTeamChatController@store`) validates (`JoinTeamChatRequest`) and persists the value into the session key `username`.
3. `/chat` routes are protected by `HasUsername` middleware; missing sessions are redirected back to `/`.
4. `ChatController@index` fetches latest messages via `ChatMessageInterface` and renders the `ChatRoom` Inertia component.
5. `ChatController@store` validates (`SendChatMessageRequest`), persists via `EloquentChatMessageService`, and redirects back with flash messaging.

## HTTP Endpoints
| Method | Path | Description | Auth | Controller |
| --- | --- | --- | --- | --- |
| GET | `/` | Render join form. | Public | `JoinTeamChatController@index` |
| POST | `/` | Store username in session, redirect to `/chat`. | Public | `JoinTeamChatController@store` |
| GET | `/chat` | Render chat room with paginated messages. | Session | `ChatController@index` |
| POST | `/chat` | Persist a new chat message. | Session | `ChatController@store` |

### `POST /`
- Body: `username` (string, required, 3–255 chars).
- Success: 302 redirect to `/chat`, session value set.
- Failure: validation errors, redirect back with errors.

### `GET /chat`
- Guarded by `HasUsername` middleware; missing session triggers 302 redirect to `/`.
- Response: Inertia `ChatRoom` component with `messages` from `ChatMessage::latest()->simplePaginate(50)`.

### `POST /chat`
- Guarded by `HasUsername` middleware.
- Body: `message` (string, min length 1; max TBD).
- Success: message persisted, redirect back with `success` flash.
- Failure: validation errors or generic `Failed to send message` flash on exceptions.

## Error Handling & Status Codes
- Validation uses Laravel’s default redirect-with-errors (HTTP 302 + error bag).
- Unauthorized access (missing `username` session) results in 302 redirect to `/`.
- Successful posts return 302 to avoid double submissions via refresh.

## Testing
Feature specs cover all flows under `tests/Feature`:
- `JoinTeamChatTest` → username validation + session storage
- `GetMessagesTest` → session protection + message payload
- `SendMessageTest` → send flow, validation, auth requirements

Execute the full suite via Sail:
```bash
./vendor/bin/sail test
```