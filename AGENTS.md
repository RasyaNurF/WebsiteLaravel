# AGENTS.md

## Stack
- Laravel 13.32 (PHP ^8.3), Tailwind CSS v4 via `@tailwindcss/vite` (no `tailwind.config.js`), Vite 8, PHPUnit 12.
- Session web app only: `bootstrap/app.php` wires `web` + `console` + health, no API routes. UI copy/routes are Indonesian (e.g. `/lupa-kata-sandi`, `/karier/{career:slug}/lamar`).
- `CLAUDE.md` holds full Laravel Boost guidelines; read it for backend work.

## Architecture
- `routes/web.php`: public CMS pages (tentang, layanan, portfolio, blog, karier — detail routes bind by `{model:slug}`), `/kontak` chat (`ChatController`, `throttle:10,1`) + `/kontak/permintaan` (`ProjectInquiryController`, `throttle:5,1`), `guest` auth group, `/dashboard` redirects to `admin.dashboard`. `/admin` group requires `auth` + `admin.ability:<resource>.view` per section.
- Validation lives in `app/Http/Requests/Admin/*Request` with `authorize(): true` — ability checks belong in the route middleware, not the request.
- Admin CRUD convention (see `ArticleController`): `index` filters + `paginate(15)->withQueryString()` + `breadcrumbs`; `create`/`edit` share one `form.blade.php`; `store`/`update` use FormRequest + `HandlesImageUploads` then redirect with Indonesian `success` flash; `destroy` deletes files first, then the model.
- Images via `HandlesImageUploads`: `{field}_file` stores to `public` disk folder, `{field}_remove` deletes, otherwise old value is kept. Rule shape: `image:allow_svg`, `mimes:jpg,jpeg,png,webp,gif,svg`, `max:5120` — SVG is intentionally allowed. Always fake storage in tests: `Storage::fake('public')`.
- Slugs via `Models\Concerns\GeneratesSlug`: auto-generated unique slug on create (`title` source by default); regenerated when source changes unless `slug` was manually set.
- AuthZ: `AdminRole` enum (`super_admin`/`admin`/`editor`) + `User::hasAbility()` (requires `is_active`) + `EnsureAdminHasAbility` (`admin.ability` alias) + `Gate::before` in `AppServiceProvider`. `UserFactory` defaults to `Admin` with `superAdmin()`/`editor()` states; inactive users are denied everything.
- Maintenance: `RedirectIfMaintenance` (`maintenance` alias) on public routes reads `SiteSetting::isMaintenanceMode()` (`maintenance_mode` key), renders `maintenance` view at 503; skips `admin/*`, login/logout, and users with `settings.view`.
- Seeding: `DatabaseSeeder` runs `LandingContentSeeder` + `CompanyContentSeeder`, creates superadmin `admin@nusakode.id` / `password`, default `SiteSetting`s (`maintenance_mode=0`), and `SeoMeta::defaultPaths()`.
- Views: public pages at `resources/views/*.blade.php`; admin CRUD at `resources/views/admin/<resource>/` (`index` + shared `form.blade.php`); layouts are `layouts/site.blade.php` (public) vs `admin/layouts/app.blade.php`. Homepage data comes from an `AppServiceProvider` composer on `welcome` (DB-driven with static fallbacks; `img/`-prefixed paths are `public/` assets, not storage).
- Tests in `tests/Feature/` cover auth, chat, inquiries, maintenance, authorization, CRUD, and image uploads — mirror the nearest one when adding coverage.

## Commands
- First-time setup: ensure `database/database.sqlite` exists, then `composer run setup` (install, `.env`, key, migrate, npm build).
- Dev: `composer run dev` (app + queue + logs). Frontend only: `npm.cmd run dev` / `npm.cmd run build` (`npm.ps1` is blocked by execution policy — always use `npm.cmd`).
- Tests: `composer run test` (clears config first). Focused: `php artisan test --compact <path>` or `--filter=Name`.
- Scaffold with `php artisan make:* --no-interaction`; tests via `php artisan make:test --phpunit {Name}` (no suite prefix, e.g. `ExampleTest`).

## Gotchas
- DB is sqlite locally; `phpunit.xml` forces sqlite `:memory:` for tests — no external DB needed. Don't assume MySQL even on Laragon.
- Frontend entries are `resources/css/app.css` + `resources/js/app.js`. Invisible UI change or Vite manifest error → `npm.cmd run build`. Dev CSS comes from the Vite server (`http://[::1]:5173`); restart `npm.cmd run dev` so Tailwind re-scans new classes.
- After touching PHP files: `vendor/bin/pint --dirty --format agent`.
- Shell is Windows PowerShell 5.1: chain with `; if ($?) { ... }`, quote spaced paths; tinker uses single quotes outside, double inside: `php artisan tinker --execute 'User::where("active", true)->count();'`.
- Boost MCP (`php artisan boost:mcp`, wired in `opencode.json`/`.mcp.json`) preferred over manual equivalents: `database-schema` before migrations/models, `database-query` for read-only SQL, `search-docs` before version-sensitive Laravel APIs, `get-absolute-url` before sharing a URL.
- Skills in `.agents/skills/`: activate `laravel-best-practices` (backend), `testing-best-practices` (tests), `tailwindcss-development` (UI) when working in those areas.
- Follow sibling-file conventions; don't add top-level directories or dependencies without approval; create docs files only when asked.
