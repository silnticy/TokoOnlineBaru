# TokoOnlineBaru — Web Programming III

Laravel 10 online store (TokoOnline). The admin backend was built in Web Programming II; Web Programming III adds the customer-facing storefront, week by week.

This README has two jobs:

1. **Progress tracker** — documents **finished weeks only**, with a step-by-step "How to check" guide per week.
2. **Onboarding context** — enough background for a new agent (or human) to understand the project and continue with the next week without re-exploring everything.

## Project context

- The full week-by-week plan lives in **`../project.md`** (workspace root, next to the app folder). It contains 12 weekly briefs; weeks must be done **in order** (each builds on the previous one). The module has **no Week 8** — numbering jumps from 7 to 9.
- Each brief lists tasks plus **"Known issues to fix"** — the module's sample code contains typos/inconsistencies that must be corrected, not copied.
- **Already done in WP II (do not rebuild):** tables `user`, `kategori`, `produk`, `foto_produk`; models `User`, `Kategori`, `Produk`, `FotoProduk`; backend controllers `BerandaController`, `LoginController`, `UserController`, `KategoriController`, `ProdukController`; admin views under `resources/views/backend/` (Matrix Admin template); helper `App\Helpers\ImageHelper::uploadAndResize()`.
- **WP III builds:** the public storefront using the E-Shop (Colorlib) template, themed as a traditional Indonesian snack store ("Jajanan Tradisional").
- **Customer feature design:** `docs/blueprint-customer.md` — `user` + `customer` table structure, their 1 : 0..1 relation and the Google-login data flow.

## Running the project

1. Start **MySQL** and **Mailpit** from Laragon (Apache optional).
2. Serve the app:

   ```
   php artisan serve
   ```

3. Open http://127.0.0.1:8000

| Area | URL | Credentials |
| --- | --- | --- |
| Storefront | http://127.0.0.1:8000 | — |
| Admin backend | http://127.0.0.1:8000/backend/login | `kelompok3@gmail.com` / `kelompok123@` |
| Mailpit (mail catcher) | http://localhost:8025 | — |
| Database browser (phpMyAdmin) | http://localhost/phpmyadmin/ | auto-login as `adminer` (MySQL user with rights on `db_tokoonline` only) |
| Database browser (Adminer) | http://localhost/adminer/ | `adminer` / `adminer` |

- Database: `db_tokoonline` (MySQL, user `root`, empty password). Seeded users: `kelompok3@gmail.com` (Super Admin — the module's seeded `fauzi@gmail.com`, renamed at the group's request) and two regular users — passwords `kelompok123@` (kelompok3) / `P@55word` (others).
- `.env` mail settings point at Mailpit on `127.0.0.1:1025` (`MAIL_HOST=127.0.0.1` — the Laragon install does not resolve the docker hostname `mailpit`).
- Product images use `php artisan storage:link`; uploads live in `storage/app/public/img-produk/`.

## Conventions (follow these)

- Table names are **singular** (`user`, `kategori`, `produk`, `foto_produk`, `customer`, and later `order`, `order_item`).
- Indonesian naming for fields and UI text.
- Backend views extend `backend.v_layouts.app`; frontend views extend `v_layouts.app`. Content goes in `@section('content')`.
- Frontend layout: `resources/views/v_layouts/app.blade.php`. Frontend views are `v_<name>/<page>.blade.php` (e.g. `v_beranda/index.blade.php`).
- Asset links use `asset('frontend/...')`, `asset('image/...')`, `asset('storage/img-produk/...')`. Product photos have size variants: prefixes `thumb_sm_`, `thumb_md_`, `thumb_lg_`.
- Product `status`: `1` = published, `0` = blocked. Blocked products must never appear on the storefront.
- Every `route('...')` used in a view must exist in `routes/web.php`. All admin/backend routes stay behind `auth` middleware.

## Agent workflow (do this every week)

1. Read the current week's brief in `../project.md`.
2. Implement the tasks in order; also fix the week's "Known issues" instead of copying the module's bugs.
3. Verify: run the app, hit the pages the brief mentions, and check that referenced assets/routes return 200.
4. **Update this README**: add a section for the finished week (template below) and update the status table.

### Week section template

```markdown
### Week N — <Title> :white_check_mark:

Completed: <date>

**Goal:** <one line from the brief>

**What was done** — bullets with file paths

**Known issues from the module fixed** — from the brief's list

**How to check** — numbered, step-by-step browser walkthrough with expected results

**Files to inspect** — table: file → what changed

**Verified** — test results (status codes, assets checked)
```

## Status

| Week | Topic | Status |
| --- | --- | --- |
| 1 | Frontend Setup and Home Page | :white_check_mark: Done |
| 2 | Product Display (list, detail, category filter, all products, pagination) | :white_check_mark: Done |
| 3 | Customer Registration and Login with Google (Socialite) | :white_check_mark: Done |
| 4 | Account Management (frontend session + backend customer list) | Not started |
| 5 | Route Groups and Middleware (customer account page) | Not started |
| 6 | Shopping Cart | Not started |
| 7 | RajaOngkir Shipping Cost API (standalone test page) | Not started |
| 9 | Ordering and Checkout Flow | Not started |
| 10 | Order Management (backend) and Invoices | Not started |
| 11 | Order Chart (admin dashboard) | Not started |
| 12 | Payment Gateway with Midtrans (Snap) | Not started |
| 13–15 | Group Project Presentation (no code) | — |

Detailed descriptions for unfinished weeks stay in `../project.md` — this README only documents finished work.

## Progress

### Week 1 — Frontend Setup and Home Page :white_check_mark:

Completed: 2026-10-15

**Goal:** install the E-Shop template as the public layout and render a home page at `/`.

**What was done**

- `public/frontend/` — E-Shop (Colorlib) template installed:
  - full template extracted to `public/frontend/eshop/`
  - `css/`, `fonts/`, `img/`, `js/` copied to `public/frontend/`
  - banner images `banner01.jpg`–`banner03.jpg` in `public/frontend/banner/`
- `public/image/logo.png` and `public/image/icon_univ_bsi.png` added (header/footer logo, favicon).
- `resources/views/v_layouts/app.blade.php` — public layout derived from the template's `index.html`:
  - all asset links use `asset('frontend/...')`
  - 3 home banner slides (`#home-slick`) use `asset('frontend/banner/bannerNN.jpg')` with captions "Jajanan Tradisional" / "Khas Makanan Indonesia" and button "Pesan Sekarang"
  - header/footer text themed for the store (traditional Indonesian snacks)
  - static product cards for now (moved to the beranda view in Week 2)
- `BerandaController::index()` — returns the 6 newest published products (`status = 1`, ordered by `updated_at` desc, paginate 6) and `judul` = "Halaman Beranda".
- `resources/views/v_beranda/index.blade.php` — extends `v_layouts.app`, content section is empty for now (filled in Week 2).
- `routes/web.php` — `/` redirects to route `beranda`; added `GET /beranda` → `BerandaController@index` (name `beranda`). All existing backend routes kept behind `auth`.

**Known issues from the module fixed**

- Footer logo used `./img/logo.png` → now `asset('image/logo.png')`.
- Typo "Halan Beranda" → "Halaman Beranda".

**How to check**

1. Start MySQL in Laragon, then run `php artisan serve` and open http://127.0.0.1:8000
   → The browser should **redirect to `/beranda`** and show the storefront.
2. Check the top of the page → golden welcome bar "Selamat datang di Jajanan Tradisional!", logo on the left, search box "Cari produk...", "Akun Saya" and "Keranjang: Rp. 0" on the right.
3. Check the navigation below the header → "Kategori" (Makanan, Minuman) and menu "Beranda / Produk / Lokasi / Hubungi Kami".
4. Watch the banner slider (`#home-slick`) → 3 slides rotate automatically, captions "Jajanan Tradisional" / "Khas Makanan Indonesia", button "Pesan Sekarang". All 3 banner images must load.
5. Scroll down → "Produk Terbaru" section with 4 demo cards (Kue Lapis Tradisional, Onde-Onde Spesial, Klepon Gula Aren, Pastel Basah). **Note:** these are static template placeholders — Week 2 replaces them with real products from the database.
6. Check the footer → store logo, description, social icons, link columns, subscribe form, and copyright with the current year.
7. Open the browser tab → favicon shows the BSI icon (`public/image/icon_univ_bsi.png`).
8. Regression check (backend untouched) → open http://127.0.0.1:8000/backend/login and log in with `kelompok3@gmail.com` / `kelompok123@`; the admin beranda still shows "Selamat Datang, Mahasiswa BSI".

**Files to inspect**

| File | What changed |
| --- | --- |
| `routes/web.php` | `/` redirects to `beranda`; new `/beranda` route |
| `app/Http/Controllers/BerandaController.php` | new `index()` method |
| `resources/views/v_layouts/app.blade.php` | new public layout (new file) |
| `resources/views/v_beranda/index.blade.php` | new beranda view (new file) |
| `public/frontend/*`, `public/image/*` | new assets |

Verify routes were registered: `php artisan route:list --except-vendor` → look for `beranda`.

**Verified**

- `http://127.0.0.1:8000/` → 302 to `/beranda`, renders with status 200.
- All 21 local assets (css, js, images, banners, logo, favicon) return 200 — no broken assets.

### Week 2 — Product Display (list, detail, category filter, all products, pagination) :white_check_mark:

Completed: 2026-10-15

**Goal:** render database products on the storefront: home list, detail page, category filter, all-products page and pagination.

**What was done**

- Seeded 8 products (7 published, 1 blocked: "Kerupuk Melinjo") — photos are free-license images from Wikimedia Commons (kue lapis, onde-onde, klepon, pastel, risoles, es cendol, wedang jahe, emping melinjo) center cover-cropped to 3:4 and saved into `storage/img-produk/` with `thumb_sm_`/`thumb_md_`/`thumb_lg_` variants; 2 extra photos attached to "Kue Lapis Tradisional" via `foto_produk` so the detail gallery has multiple images.
- `resources/views/v_layouts/app.blade.php`:
  - static "Produk Terbaru" block removed, replaced with `@yield('content')` (the section now renders each page's content)
  - `#home` banner wrapped in `@if (request()->segment(1) == '' || request()->segment(1) == 'beranda')` — banner shows only on the home page
  - `$kategori` loaded once at the top of `<body>` (`DB::table('kategori')->orderBy('nama_kategori','asc')->get()`), used by the search select and the category nav
  - `category-nav` gets `show-on-click` on non-home pages; one loop renders the categories with `route('produk.kategori', $k->id)` links
  - menu nav: Beranda → `route('beranda')`, Produk → `route('produk.all')`, Lokasi / Hubungi Kami stay `#`
- `resources/views/v_beranda/index.blade.php` — "Produk Terbaru" grid looping `$produk`: category label, `thumb_md_` image, `Rp.`-formatted price, name and "Detail Produk" both linking to `route('produk.detail', $row->id)`, plus the Pesan form placeholder (wired in Week 6).
- `resources/views/v_produk/produkkategori.blade.php` (Filter Kategori) and `resources/views/v_produk/index.blade.php` (Semua Produk) — aside with the "Filter Kategori" widget + 3-column card grid + bottom `.store-filter` with `{{ $produk->links('vendor.pagination.custom') }}`.
- `resources/views/v_produk/detail.blade.php` — `thumb_lg_` main image, `thumb_sm_` thumbnail strip, additional `foto_produk` photos, category label, name, price, `{!! $row->detail !!}`, weight (gram) and stock, Pesan button.
- `resources/views/vendor/pagination/custom.blade.php` — `<ul class="pagination">` with `&laquo;`/`&raquo;` prev/next, disabled/active states and numbered links.
- `app/Http/Controllers/ProdukController.php` — new `detail($id)` (404 for blocked or unknown products), `produkKategori($id)`, `produkAll()`; all filter `status = 1`, order by `updated_at` desc and pass `$kategori` for the sidebar.
- `routes/web.php` — `GET /produk/all`, `GET /produk/kategori/{id}`, `GET /produk/detail/{id}` registered before the existing `produk/{id}` route so `/produk/all` is not captured by the backend show route.

**Visual fixes (after review)**

- Reported issue: product images looked skewed ("too thick"). Root cause: `ProdukController::store()`/`update()` generated `thumb_md_` (500x519) and `thumb_sm_` (100x110) with a forced height, squashing the 3:4 photos (~22% for `thumb_md_`). Both methods now resize by width only (`500, null` / `100, null`), same as `thumb_lg_` already did.
- All seeded product photos replaced with matching free-license Wikimedia Commons images (kue lapis, onde-onde, klepon, pastel, risoles, es cendol, wedang jahe, emping melinjo), center cover-cropped to 3:4: originals 900x1200, `thumb_lg_` 800x1067, `thumb_md_` 500x667, `thumb_sm_` 100x133. Existing filenames were overwritten, so the database was left untouched. The 2 gallery extras of "Kue Lapis Tradisional" (previously a spaghetti illustration and a Coca-Cola bottle) were also replaced with kue lapis photos.
- Template "E-SHOP" logo replaced with a "Jajanan Tradisional" wordmark (`public/image/logo.png`, 420x140 PNG, orange `#F8694A` + dark `#30323A`) — renders at 210x70 in the header and footer through the existing `max-height: 70px` rule.

**Known issues from the module fixed**

- `detail()` array key is quoted (`'judul' =>`, not `judul =>`).
- `$kategori` is defined once before the home/non-home branches, so non-home pages don't error.
- No stray duplicate `<ul class="category-list">`; a single loop renders the category nav.
- Product-name links (plus a "Detail Produk" button) point to `route('produk.detail', ...)` instead of `#`.
- Pesan forms are placeholders (`action="#"`) until Week 6; blocked products never appear and their detail page returns 404.

**How to check**

1. Start MySQL in Laragon, run `php artisan serve`, open http://127.0.0.1:8000 → redirects to `/beranda`.
2. Home → "Produk Terbaru" shows 6 newest published products (Kue Lapis Tradisional, Onde-Onde Spesial, Klepon Gula Aren, Pastel Basah, Risoles Mayo, Es Cendol Dawet), each with a category badge, price like "Rp. 25.000" and a real snack photo at true 3:4 (no distortion). "Wedang Jahe" (7th) and blocked "Kerupuk Melinjo" are not on this page.
3. Click a product name or "Detail Produk" → detail page with main image, thumbnail strip, category badge, name, price, Stok, Berat in gram, description and a Pesan button. On "Kue Lapis Tradisional" the strip also has 2 extra photos.
4. Click "Produk" in the menu → `/produk/all`: 6 products, "Filter Kategori" sidebar, custom pagination bottom right; click "2" or `»` → only "Wedang Jahe". The banner is gone on this page and the category dropdown is collapsed until clicked (`show-on-click`).
5. Open the "Kategori" dropdown (or the sidebar) → `Makanan` shows only the 5 published food products, `Minuman` only "Es Cendol Dawet" and "Wedang Jahe".
6. Try `/produk/detail/8` (the blocked Kerupuk Melinjo) → 404; it appears nowhere on the storefront.
7. Regression check → http://127.0.0.1:8000/backend/login still loads and admin login works.

**Files to inspect**

| File | What changed |
| --- | --- |
| `routes/web.php` | 3 new public product routes (before `produk/{id}`) |
| `app/Http/Controllers/ProdukController.php` | new `detail`, `produkKategori`, `produkAll`; store/update thumbnails resize by width only (no forced height) |
| `resources/views/v_layouts/app.blade.php` | `@yield('content')`, banner conditional, category nav + menu links, `$kategori` loaded once |
| `resources/views/v_beranda/index.blade.php` | "Produk Terbaru" loop over `$produk` |
| `resources/views/v_produk/index.blade.php`, `produkkategori.blade.php` | list views with Filter Kategori sidebar + pagination |
| `resources/views/v_produk/detail.blade.php` | product detail with gallery |
| `resources/views/vendor/pagination/custom.blade.php` | new custom pagination (new file) |
| Database | 8 seeded products, 2 `foto_produk` rows, images in `storage/img-produk/` |
| `public/storage/img-produk/*.jpg` | product + gallery photos regenerated from Wikimedia Commons, 3:4 (900x1200 / 800x1067 / 500x667 / 100x133) |
| `public/image/logo.png` | "Jajanan Tradisional" wordmark (was the template "E-SHOP" logo) |

**Verified**

- `/` → 302 to `/beranda` (200). Home shows exactly 6 cards, correct ordering, blocked product absent.
- `/produk/all` page 1 = 6 cards; `?page=2` = 1 card ("Wedang Jahe"); custom pagination with prev/next and active state.
- Category pages filter correctly (Makanan 5 items, Minuman 2 items); blocked product absent everywhere; `/produk/detail/8` → 404; `/produk/detail/999999` → 404.
- Detail page: `thumb_lg_`/`thumb_sm_`/additional photos, price "Rp. 25.000", Berat 250 gram, Stok 40, description HTML rendered.
- All 32 image variants return 200; `thumb_md_` fetched over HTTP → 200 `image/jpeg`.
- Regression: `/backend/login` → 200; PHP lint clean on `ProdukController.php` and `routes/web.php`.
- After the visual fixes: all 40 product image files (8 products + 2 extras × original/lg/md/sm) verified at exact 3:4; `/beranda` and `/produk/detail/1` re-screenshotted (headless Edge) and reviewed — no distortion, logo renders at 210x70 in header and footer.
- Full Week 2 HTTP suite re-run after the fixes: 50/51 pass. The single FAIL is a known false positive in the "no wishlist/add-to-cart dead buttons" check (footer's `fa fa-heart-o` icon matches the pattern; there are no actual dead buttons).

### Week 3 — Customer Registration and Login with Google (Socialite) :white_check_mark:

Completed: 2026-10-17

**Goal:** register/log in storefront customers with their Google account (Laravel Socialite) — a first login creates a `user` row (role 2) plus a linked `customer` row.

**What was done**

- `laravel/socialite` installed (`composer require laravel/socialite` → `^5.31`).
- `.env` / `.env.example` — `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` (empty placeholders until the OAuth client exists) and `GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback` (must be `localhost` — Google Cloud rejects IP addresses in OAuth redirect URIs).
- `config/services.php` — `google` client block reading those three env vars.
- `database/migrations/2026_10_17_120000_create_customer_table.php` — `customer` table: `id`, `user_id` (FK → `user.id`, cascade on delete), nullable `google_id`, `google_token`, `alamat`, `pos`, timestamps.
- `app/Models/Customer.php` — extends `Authenticatable`, `$table = 'customer'`, `$fillable` limited to columns that actually exist, `user()` belongsTo, and a `deleting` hook that deletes the related `user` row.
- `app/Http/Controllers/CustomerController.php`:
  - `redirect()` → `Socialite::driver('google')->redirect()`
  - `callback()` → finds the `User` by Google email; if new, creates the `user` (role `'2'`, status 1, random 32-char hashed password) and the `customer` (google_id + google_token), then `Auth::login()`; existing accounts are logged in **only when role is 2**; every failure redirects to `/` with a `msgError` flash
  - `logout(Request)` → `Auth::logout()`, session invalidate + CSRF token regenerate, redirect `/`
- `routes/web.php` — `GET /auth/redirect` (`auth.redirect`), `GET /auth/google/callback` (`auth.callback`), `POST /logout` (`logout`).
- `resources/views/v_layouts/app.blade.php` — Account-area "Login" and "Daftar" links point to `route('auth.redirect')`.

**Known issues from the module fixed**

- `Customer::$fillable` no longer lists `user` columns (`nama, email, status, role, password, hp, foto`) — only the real `customer` columns.
- Default password `'default_password'` replaced with `Hash::make(Str::random(32))`.
- Admin/superadmin emails cannot log in through Google: role ≠ 2 → redirect to `/` with `msgError` "Email ini terdaftar sebagai akun admin, silakan login melalui halaman backend."; admin login stays on `/backend/login`.
- An email that already exists in `user` is reused (no duplicate `user` row), per the module's flow.

**How to check**

1. One-time manual step (user): in the Google Cloud Console create a project, configure the OAuth consent screen (External), create an OAuth client of type "Web application" (the console moved this to **Google Auth Platform → Clients**, no longer under "Credentials") with redirect URI `http://localhost:8000/auth/google/callback` — Google shows *"Invalid URL: cannot contain an IP address"* if `127.0.0.1` is used — then put the Client ID and Secret into `.env` (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`). Leave the consent screen's *App domain* and *Authorized domains* fields empty: they never accept `localhost` or IPs (*"Invalid URL: cannot contain a localhost domain"*) and are not required while testing. While the consent screen is in "Testing", add the Gmail used for testing as a test user.
2. Start MySQL in Laragon, run `php artisan serve`, and for the Google flow open **http://localhost:8000** (not `127.0.0.1`): the OAuth `state` is stored in the session cookie, and a cookie set on one host is not sent to the other. Other pages work the same on both hosts.
3. Header "Akun Saya" → "Login" (or "Daftar") → the browser goes to `accounts.google.com`; pick an account and allow.
4. You land back on `/beranda`. The header still shows "Login / Daftar" — expected for now; showing the logged-in name arrives in Week 4.
5. Confirm the database in the browser with **phpMyAdmin** — open http://localhost/phpmyadmin/ (Laragon's pre-configured `/phpmyadmin` alias; opens already logged in as MySQL user `adminer`) → database `db_tokoonline` → table `customer`: one row per registered customer with `google_id` filled; table `user`: the matching row has `role = 2`, `status = 1` (and `customer.google_token` is filled too). In the **SQL** tab, the same check is:
   `SELECT u.nama, u.email, u.role, u.status, c.google_id FROM user u JOIN customer c ON c.user_id = u.id ORDER BY u.id DESC LIMIT 1;`
   Alternative, **Adminer** (also bundled with Laragon): http://localhost/adminer/ → Server `127.0.0.1`, Username `adminer`, Password `adminer`, Database `db_tokoonline`. The dedicated `adminer` MySQL user exists because browser DB tools refuse passwordless logins; the app itself still uses MySQL `root` with an empty password. Recreate the checker user with:
   `CREATE USER IF NOT EXISTS 'adminer'@'localhost' IDENTIFIED BY 'adminer'; CREATE USER IF NOT EXISTS 'adminer'@'127.0.0.1' IDENTIFIED BY 'adminer'; GRANT ALL PRIVILEGES ON db_tokoonline.* TO 'adminer'@'localhost'; GRANT ALL PRIVILEGES ON db_tokoonline.* TO 'adminer'@'127.0.0.1'; FLUSH PRIVILEGES;`
6. Click Login again with the same Gmail → you end up logged in on `/beranda` again; no duplicate `user` row is created.
7. Admin restriction: try Login with the admin email `kelompok3@gmail.com` → you are **not** logged in as admin (still a guest) and no `customer` row is created; the `msgError` flash is set and becomes visible once the layout renders flash messages (Week 4).
8. Without Google credentials yet: `/auth/redirect` still redirects to Google's consent URL (with an empty `client_id`), and `/auth/google/callback` reached without OAuth state redirects gracefully to `/`.

**Files to inspect**

| File | What changed |
| --- | --- |
| `composer.json`, `composer.lock` | added `laravel/socialite` `^5.31` |
| `.env`, `.env.example` | `GOOGLE_CLIENT_ID` / `GOOGLE_CLIENT_SECRET` / `GOOGLE_REDIRECT_URL` |
| `config/services.php` | `google` block |
| `database/migrations/2026_10_17_120000_create_customer_table.php` | new `customer` table (new file) |
| `app/Models/Customer.php` | new model + `deleting` hook (new file) |
| `app/Http/Controllers/CustomerController.php` | `redirect`, `callback`, `logout` (new file) |
| `routes/web.php` | `auth.redirect`, `auth.callback`, `logout` routes |
| `resources/views/v_layouts/app.blade.php` | Account-area Login/Daftar links |
| `docs/blueprint-customer.md` | customer table/relation design doc (new file) |

**Verified**

- Kernel suite with mocked Socialite: **21/21 PASS** — new `user` + `customer` created with role 2 / status 1 / bcrypt hash, session authenticated, admin email rejected without login (flash set), logout tears the session down, test rows cleaned up afterwards.
- HTTP suite against `php artisan serve`: **39/39 PASS** — `/auth/redirect` → 302 to `https://accounts.google.com/o/oauth2/auth?...` with the configured `redirect_uri`; callback without OAuth state → 302 back to `/`; `POST /logout` → 419 without CSRF and 302 to `/` with it; storefront pages unchanged (home 6 cards, all-products 6 + 4, each category 2, blocked product 404); `/backend/login` 200; all checked assets 200.
- Database after the mocked/HTTP suites: 3 users, 0 customers (no test leftovers).
- **Real end-to-end Google login succeeded (2026-10-17)** with the user's own OAuth client: registering with a real Google account created `user` id 6 ("rahmat mubarok", role 2, status 1) and `customer` id 3 (`google_id` and `google_token` filled); the same account logging in again does not create duplicates. The header still shows "Login / Daftar" until Week 4. (`.env` holds the real Google credentials; `.env.example` keeps empty placeholders.)
- Database browser: **phpMyAdmin 5.2.3** at http://localhost/phpmyadmin/ (auto-login as MySQL user `adminer`; installed into Laragon's pre-existing `etc/apps/phpMyAdmin` alias target) — registration rows are visible under `db_tokoonline` → `user` / `customer`. Adminer remains available at http://localhost/adminer/ (`adminer` / `adminer`).
- Environment note: on this machine plain `php artisan serve` initially failed with `Failed to listen on 127.0.0.1:8000 (reason: ?)` — a known Laravel-on-Windows bug (Herd's `php.ini` had `variables_order = "EGPCS"`; Laravel's env whitelist for the child server is case-sensitive, so `Path`/`SystemRoot` were stripped and `php -S` could not bind). Fixed by setting `variables_order = "GPCS"` in `C:\Users\TAMU\.config\herd\bin\php84\php.ini` (backup: `php.ini.egpcs-backup`); plain `php artisan serve` now works.

# Week 5 — Route Group and Middleware

## Goal

The goal of Week 5 is to implement **Route Groups and Middleware** for customer account management.

The implementation ensures that customer account routes are protected and can only be accessed by authenticated customers. It also organizes related customer routes into a single middleware group to make the routing structure cleaner and easier to maintain.

---

## What Was Done

 1. Created `IsCustomer` Middleware

A custom middleware named `IsCustomer` was created to check whether the authenticated user is allowed to access customer pages.

```text id="17umzh"
app/Http/Middleware/IsCustomer.php
```

The middleware verifies that:

- The user is authenticated.
- The authenticated user has the customer role.
- Unauthorized users are redirected to the login page.

```php id="9t3cvp"
if (auth()->check() && auth()->user()->role == 2) {
    return $next($request);
}

return redirect('/auth/redirect')
    ->with('msgError', 'You must login as a customer');
```

 2. Registered Customer Middleware

The custom middleware was registered with the alias:

```php id="r4wws8"
'is.customer' => \App\Http\Middleware\IsCustomer::class,
```

This allows the middleware to be used easily in the application's routes.

 3. Implemented Route Group

Customer account routes were grouped under the `is.customer` middleware.

```php id="l35xmv"
Route::middleware('is.customer')->group(function () {

    Route::get('/customer/akun/{id}', [CustomerController::class, 'akun'])
        ->name('customer.akun');

    Route::put('/customer/updateakun/{id}', [CustomerController::class, 'updateAkun'])
        ->name('customer.updateakun');

});
```

This prevents the middleware declaration from being repeated on every customer route.

 4. Added Customer Account Management

The customer account feature allows an authenticated customer to:

- View their account information.
- Edit their name.
- Edit their email.
- Edit their phone number.
- Edit their address.
- Edit their postal code.
- Upload or update their profile photo.

 5. Added Account Access Protection

The application verifies that the requested account ID belongs to the currently authenticated user.

A customer therefore cannot manually change the URL to access another customer's account.

---

## Known Issues from the Module Fixed

Several adjustments were made while implementing the Week 5 module to keep the routes and account management consistent.

 1. Duplicate Middleware Declaration

The module initially demonstrates middleware individually on each route:

```php id="gck7bj"
Route::get(...)
    ->middleware('is.customer');

Route::put(...)
    ->middleware('is.customer');
```

This was replaced with a Route Group:

```php id="l4m2q9"
Route::middleware('is.customer')->group(function () {
    Route::get(...);
    Route::put(...);
});
```

This avoids repeating the same middleware declaration.

 2. Inconsistent Update Route

The module shows different versions of the customer update URL.

One example uses:

```text id="5k4qap"
/customer/akun/{id}/update
```

while another uses:

```text id="xjj34q"
/customer/updateakun/{id}
```

The implementation uses one consistent route:

```php id="xy9xzb"
Route::put('/customer/updateakun/{id}', [CustomerController::class, 'updateAkun'])
    ->name('customer.updateakun');
```

The Blade form also uses the named route:

```blade id="c70h3f"
route('customer.updateakun', $edit->user_id)
```

This prevents URL mismatches between the form and the route definition.

 3. Customer Account Security

Additional validation was used to make sure that a logged-in customer cannot access another customer's account simply by changing the ID in the URL.

If the requested ID does not belong to the authenticated user, the application redirects the user to their own account.

---

## How to Check

 1. Start the Laravel Application

Run:
```bash id="8msw5a"
php artisan serve
```

Open:
```text id="rwq4ej"
http://127.0.0.1:8000
```

### 2. Check Customer Routes

Run:
```bash id="vvp78b"
php artisan route:list --name=customer
```

The application should contain routes for:
```text id="uxygeu"
customer.akun
customer.updateakun
```

### 3. Test Middleware

Without logging in, try to access:
```text id="hd9edr"
/customer/akun/1
```
The application should prevent access and redirect the user to authentication.

### 4. Test Customer Account

Login as a customer and open **Akun Saya**.
The customer account page should display the current customer information.

### 5. Test Account Update

Change customer information such as:
```text id="bzd1fj"
Name
Email
Phone Number
Address
Postal Code
Profile Photo
```
Click **Save Changes**.
The updated information should be stored successfully.

### 6. Test Account Protection

For example, if the logged-in user has ID `3`, access:
```text id="y3id8m"
/customer/akun/3
```
This should work.

Then manually change the URL to:
```text id="2ov1la"
/customer/akun/2
```
The application should prevent the customer from accessing the other account and redirect them back to their own account.

---

## Files to Inspect

The main files related to the Week 5 implementation are:

```text id="bh6tn4"
app/
├── Http/
│   ├── Controllers/
│   │   └── CustomerController.php
│   │
│   ├── Middleware/
│   │   └── IsCustomer.php
│   │
│   └── Kernel.php
│
resources/
└── views/
    └── v_customer/
        └── edit.blade.php

routes/
└── web.php

storage/
└── app/
    └── public/
        └── img-customer/
```

## Verified

The Week 5 implementation was checked for the following functionality:

- [v] `IsCustomer` middleware created.
- [v] Customer middleware registered.
- [v] Customer routes grouped using Route Group.
- [v] Customer account route protected by middleware.
- [v] Customer account page created.
- [v] Customer profile information can be edited.
- [v] Customer update route implemented.
- [v] Profile photo upload supported.
- [v] Unauthorized access is redirected.
- [v] Customers cannot access another customer's account by changing the URL.
- [v] Customer route names can be checked using `php artisan route:list --name=customer`.

**Week 5 — Route Group and Middleware: Completed ✅**