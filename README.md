# Vanilla Core

A tiny MVC framework written from scratch in vanilla PHP — a miniature Laravel, built to understand how modern frameworks actually work under the hood.

Everything here except Composer's autoloader is hand-written: the **service container**, the **router**, the **middleware pipeline**, the **request/response objects**, the **model layer**, and a **Blade-style template engine**. The name *Vanilla* says it all — plain PHP, no framework beneath it.

> **Why it exists:** to demystify Laravel's "magic" by rebuilding its core concepts by hand. Each piece maps to a real Laravel component, so building them made the internals click. (And if Laravel ever vanishes overnight — this still runs.)

## Features

- **Service container** with automatic dependency injection via Reflection
- **Regex router** with named parameters, route groups, and specificity-based matching
- **Middleware pipeline** — a real onion (before/after, short-circuiting)
- **Request / Response** objects (deferred output, sent once at the end)
- **Model layer** over PDO with validation and safe prepared statements
- **Two view engines** — a raw PHP viewer and a Blade-style **template engine** (`{{ }}`, `@if`, `@foreach`, components)
- **Auth & sessions** — hashed passwords, CSRF protection, session-fixation defence
- Global error/exception handling, `.env` config, PSR-4 autoloading

---

## How a request flows

```
public/index.php
  → load .env, register error handlers, start session
  → Request::createFromGlobals()
  → Dispatcher
      → Router.match()          find the route (+ its middleware)
      → Container.get()         build the controller (auto-wiring its dependencies)
      → Middleware pipeline     run each middleware, then the controller
      → controller returns a Response
  → Response.send()             status + headers + body, sent once
```

---

## The pieces

### Service Container — `vc/Container`

Auto-wires dependencies by reading constructor type-hints with **Reflection**. Bind a recipe when something can't be auto-built (needs config, scalars, or a factory); everything else is resolved recursively.

```php
$container->set(PDO::class, fn() => new PDO(...));   // explicit recipe
$controller = $container->get(PagesController::class); // auto-wires the rest
```

### Router — `vc/Routing/Router.php`

Registers routes as regex patterns with `{named}` parameters, and **sorts by specificity** (most literal segments first) so `/page/create` always beats `/page/{slug}` — registration order doesn't matter. Supports **route groups** that attach a middleware pipeline to many routes at once:

```php
$router->get( '/page/{slug}/', [ PagesController::class, 'showSingle' ] );

$router->group( 'auth', function ( Router $router ) {
    $router->get(  '/page/create/', [ PagesController::class, 'create' ] );
    $router->post( '/page/',        [ PagesController::class, 'store' ] );
} );
```

### Dispatcher — `vc/Routing/Dispatcher.php`

Matches the path, resolves the controller from the container, binds action arguments **by name** from the URL (via Reflection), and runs the whole thing through the middleware pipeline before returning the `Response`.

### Middleware — `vc/Http/Middleware`

A genuine **onion**, built as a recursive request-handler chain. Each middleware runs code *before* the controller, calls `$next`, then runs code *after* — and can **short-circuit** (return a response without ever reaching the controller).

```php
class VerifyCsrf implements MiddlewareInterface {
    public function process( Request $request, RequestHandlerInterface $next ): Response {
        // before: reject bad CSRF tokens…
        return $next->handle( $request );   // …or pass control inward
    }
}
```

Route groups declare their pipeline as a string (`'auth'`, `'guest'`, or piped `'auth|csrf'`); the dispatcher splits it, resolves each alias from `config/middleware.php`, and nests them around the controller. Built-in middleware: `RedirectIfGuest` (auth), `RedirectIfAuth` (guest), `VerifyCsrf`.

### Request & Response — `vc/Http`

`Request` wraps the superglobals into one object (`createFromGlobals`). Controllers **return** a `Response` (they never `echo`), so middleware can still modify it on the way out — the body is sent exactly once in `Response::send()`, after status and headers.

### Model — `vc/Database/Model.php`

An abstract Active-Record-style base over PDO: `findAll`, `find`, `insert`, `update`, `delete`, with per-model `validate()` and error collection. All user input goes through **prepared statements**; column names are allowlisted, never interpolated blindly.

### Template engine — `vc/View`

Two viewers behind one `ViewerInterface`:

- **`RawViewer`** — plain PHP views rendered into a layout via output buffering.
- **`TemplateViewer`** — a Blade-style compiler: `{{ $escaped }}` echoes, `@if / @foreach / @else` directives (balanced-paren aware), and `<vc-dir.file/>` **components** (self-closing and wrapping, with slot injection). Templates compile to PHP and run once.

Pick the engine in `.env` with `VIEWER=TMP` or `VIEWER=RAW`.

### Auth & Session — `vc/Session`

Hashed passwords (`password_hash` / `password_verify`), CSRF token generation and verification, `session_regenerate_id(true)` on login (fixation defence), and a full session teardown on logout.

---

## Requirements

- PHP **8.1+** with `ext-mbstring`
- MySQL / MariaDB
- Composer
- Apache with `mod_rewrite` (or any server that routes everything through `public/index.php`)

## Setup

```bash
composer install
cp .env-example .env
```

Fill in `.env`:

```ini
DB_HOST=localhost
DB_NAME=your_db
DB_USER=your_user
DB_PASS=your_pass

ERR_SHOW=TRUE      # show errors in dev
ERR_LOG=FALSE

VIEWER=TMP         # TMP = template engine, RAW = plain PHP views
```

Point your web server's document root at **`public/`**, then open the site. With the built-in server:

```bash
php -S localhost:8000 -t public
```

## Project structure

```
├── public/index.php      # entry point (bootstrap → dispatch → send)
├── routes/web.php         # route table + groups
├── config/                # container bindings + middleware aliases
├── app/                   # your application code
│   ├── Controllers/
│   ├── Model/
│   ├── Middleware/
│   └── Database.php
├── resources/views/       # templates + components
└── vc/                    # the framework itself
    ├── Container/          # DI container
    ├── Routing/            # Router + Dispatcher
    ├── Http/               # Request, Response, Controller, Middleware
    ├── Database/           # Model
    ├── View/               # RawViewer + TemplateViewer
    ├── Session/            # Auth + SessionManager
    ├── Exceptions/         # error handler + exceptions
    └── Support/            # global helpers
```

## How it maps to Laravel

| Vanilla Core | Laravel |
|---|---|
| `vc/Container` | `Illuminate\Container` |
| `vc/Routing` (Router + Dispatcher) | Router + HTTP Kernel |
| `vc/Http/Middleware` | the middleware pipeline |
| `vc/Http/Request` · `Response` | `Illuminate\Http\Request` · `Response` |
| `vc/Database/Model` | Eloquent |
| `vc/View/TemplateViewer` | Blade |

Built by [Alex Muha](mailto:dev.alex.muha@gmail.com) to understand how a framework's parts connect and work as one system.
