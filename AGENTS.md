# AGENTS.md

## Stack
- Laravel 13.32 (PHP ^8.3), Tailwind CSS v4 via `@tailwindcss/vite` (no `tailwind.config.js`), Vite 8, PHPUnit 12.
- No API routes. Session web app only. UI copy is Indonesian (routes/views in Indonesian, e.g. `/lupa-kata-sandi`).
- `CLAUDE.md` holds full Laravel Boost guidelines (PHP/artisan/pint/phpunit conventions); read it for backend work.
- Confirm version-sensitive APIs first: `composer show --direct` (PHP), `package.json` (JS).

## Architecture
- `routes/web.php`: `/` welcome, `/kontak` chat (`ChatController`, `throttle:10,1`), auth group (`guest`) for login/register/password-reset, `auth` group for `/dashboard` + logout. Throttled POSTs at `throttle:5,1`.
- Controllers in `app/Http/Controllers/`: `LoginController`, `RegisterController`, `PasswordResetController`, `ChatController` — hand-rolled, no Breeze/Jetstream/Fortify.
- Models: `User`, `ChatMessage` (only non-default migration is `create_chat_messages_table`).
- Views: `welcome`, `contact`, `dashboard` sit at `resources/views/` root; auth pages under `resources/views/auth/`; shared layout `resources/views/layouts/site.blade.php`. Homepage overrides the header via `@section('site-header')` (transparent glass nav + fixed positioning).
- Feature tests map 1:1 to features (`AuthTest`, `RegisterTest`, `PasswordResetTest`, `ChatTest`, `ContactPageTest`).

## Commands
- First-time setup: `composer run setup` (install, `.env`, key, migrate, npm build). Requires `database/database.sqlite` to exist for sqlite.
- Dev server: `composer run dev` (app + queue + logs). Frontend only: `npm run dev` / `npm run build`.
- Tests: `composer run test` (full suite, clears config first). Focused: `php artisan test --compact <path>` or `--filter=Name`.
- Scaffold with `php artisan make:* --no-interaction`; tests via `php artisan make:test --phpunit {Name}` (no suite prefix, e.g. `ExampleTest` not `Feature/ExampleTest`).

## Gotchas
- DB is sqlite locally; `phpunit.xml` forces sqlite `:memory:` for tests — no external DB needed. Don't assume MySQL even on Laragon.
- Frontend entries are `resources/css/app.css` + `resources/js/app.js`. Invisible UI change or Vite manifest error → `npm run build`.
- After touching PHP files: `vendor/bin/pint --dirty --format agent`.
- Shell here is Windows PowerShell 5.1: chain with `; if ($?) { ... }`, quote spaced paths; tinker uses single quotes outside, double inside: `php artisan tinker --execute 'User::where("active", true)->count();'`.
- `npm.ps1` is blocked by execution policy — call `npm.cmd run build` / `npm.cmd run dev`, not `npm`.
- Dev server serves CSS from the Vite dev server (`http://[::1]:5173`) when `npm run dev` is running; new Tailwind classes are not picked up until Vite re-scans (restart `npm run dev`). `php artisan serve` alone serves the built asset.
- Boost MCP (`php artisan boost:mcp`, wired in `opencode.json`) preferred over manual equivalents: `database-schema` before migrations/models, `database-query` for read-only SQL, `search-docs` before version-sensitive Laravel APIs, `get-absolute-url` before sharing a URL.
- Skills in `.agents/skills/`: activate `laravel-best-practices` (backend), `testing-best-practices` (tests), `tailwindcss-development` (UI) when working in those areas.
- Follow sibling-file conventions; don't add top-level directories or dependencies without approval; create docs files only when asked.
