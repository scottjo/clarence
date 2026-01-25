# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

This is a Laravel 12 application for a bowling club website. It uses Filament 5 for admin panels, Livewire 4 for interactive frontend components, and Tailwind CSS 4 for styling. The application is built with PHP 8.4.17.

**Core Technologies:**
- Laravel 12 (streamlined structure without Kernel.php)
- Filament 5 (admin panel framework, built on Livewire)
- Livewire 4 (full-page components for public site)
- Tailwind CSS 4 (CSS-first configuration using `@theme`)
- PHPUnit 11 for testing
- Laravel Horizon 5 for queue management
- Laravel Pint for code formatting

## Common Commands

### Development
```bash
# Start all development services (server, queue, logs, and vite)
composer run dev

# Run just the development server
php artisan serve

# Build frontend assets
npm run build

# Watch frontend assets
npm run dev
```

### Testing
```bash
# Run all tests
php artisan test --compact

# Run specific test file
php artisan test --compact tests/Feature/ExampleTest.php

# Run specific test by name
php artisan test --compact --filter=testName

# Run tests (via composer)
composer test
```

### Code Quality
```bash
# Format code with Pint (ALWAYS run before finalizing changes)
vendor/bin/pint --dirty

# Format all files
vendor/bin/pint
```

### Database
```bash
# Run migrations
php artisan migrate

# Fresh database with seeding
php artisan migrate:fresh --seed
```

### Artisan Commands
```bash
# Create Livewire component
php artisan make:livewire ComponentName

# Create Filament resource (use --no-interaction flag)
php artisan make:filament-resource ResourceName --no-interaction

# Create model with factory and seeder
php artisan make:model ModelName -mfs

# Create form request
php artisan make:request RequestName

# Create test (PHPUnit, not Pest)
php artisan make:test --phpunit TestName

# Create unit test
php artisan make:test --phpunit --unit TestName
```

### Project Setup
```bash
# Initial setup (install dependencies, generate key, migrate, build assets)
composer setup
```

## Application Architecture

### Frontend Architecture

The application uses **two separate frontend systems**:

1. **Public Website** - Full-page Livewire components
   - Location: `app/Livewire/`
   - Views: `resources/views/livewire/`
   - Routes: `routes/web.php`
   - Layout: `resources/views/layouts/app.blade.php`
   - All public pages are Livewire components that render full pages

2. **Admin Panel** - Filament resources
   - Location: `app/Filament/Resources/`
   - Accessed at `/admin` route (configured by Filament)
   - No custom views needed (SDUI pattern)

### Filament Resource Organization

Filament resources follow a **structured directory pattern** with separation of concerns:

```
app/Filament/Resources/
├── Heroes/
│   ├── HeroResource.php        # Main resource class
│   ├── Pages/                   # Resource pages (List, Create, Edit)
│   ├── Schemas/                 # Form schemas (HeroForm.php)
│   └── Tables/                  # Table configurations (HeroesTable.php)
├── NewsArticles/
├── Fixtures/
└── ...
```

**Key pattern:** Forms and tables are extracted into separate classes (`Schemas/` and `Tables/` directories) rather than being defined inline in the Resource class. This improves organization and reusability.

### Data Models

Core models and their purpose:
- **Hero** - Hero sections for pages (configurable images, text, styling per route)
- **IntroBlock** - Intro content blocks for pages (per route)
- **Setting** - Global site settings (club info, logos, colors, gradients)
- **NewsArticle** - News articles with slugs, images, publish dates
- **Event** - Events with dates, times, locations
- **Fixture** - Sports fixtures with type enum, opponent, venue
- **Result** - Match results (has one-to-one relationship with Fixture)

### Middleware & Settings System

The `LoadSettings` middleware (in `app/Http/Middleware/`) runs on every request and:
1. Loads the global `Setting` singleton
2. Loads route-specific `Hero` based on route name
3. Loads route-specific `IntroBlock` based on route name
4. Shares all via `View::share()` for use in layouts and components

This allows pages to have customizable hero sections and intro blocks managed through Filament.

### Laravel 12 Structure Notes

- **No `app/Http/Kernel.php`** - Middleware configured in `bootstrap/app.php` using `Application::configure()->withMiddleware()`
- **No `app/Console/Kernel.php`** - Console commands auto-discovered from `app/Console/Commands/`
- **Service providers** in `bootstrap/providers.php`
- **Routing, middleware, and exceptions** all configured in `bootstrap/app.php`

### Filament Patterns

**Namespace Conventions:**
- Form fields: `Filament\Forms\Components\`
- Infolist entries: `Filament\Infolists\Components\`
- Layout components: `Filament\Schemas\Components\`
- Schema utilities (Get, Set): `Filament\Schemas\Components\Utilities\`
- Actions: `Filament\Actions\`
- Icons: `Filament\Support\Icons\Heroicon` enum

**Common patterns:**
- Use `Get $get` in closures to read other form field values
- Use `state()` with closures for computed column values
- Use `->live()` on form fields for reactive updates
- Actions encapsulate buttons with optional modal forms

### Tailwind CSS 4 Specifics

- Configuration is **CSS-first** using `@theme` directive in CSS files
- Import Tailwind with `@import "tailwindcss";` not `@tailwind` directives
- No `tailwind.config.js` file needed
- Use new utility names (e.g., `text-ellipsis` not `overflow-ellipsis`)
- Dark mode supported via `dark:` prefix on components

## Testing Guidelines

- **PHPUnit only** - Convert any Pest tests to PHPUnit
- Run affected tests after every code change
- Use factories for test models (check for custom states first)
- Run `vendor/bin/pint --dirty` before finalizing
- Most tests should be feature tests (not unit tests)
- For Filament tests, use `livewire()` or `Livewire::test()`
- Always authenticate before testing Filament panel functionality

## Laravel Boost MCP Tools

This project uses Laravel Boost MCP server which provides:
- `list-artisan-commands` - Check available Artisan commands and options
- `get-absolute-url` - Get correct URL scheme/domain/port for sharing links
- `tinker` - Execute PHP to debug or query Eloquent models
- `database-query` - Read from database directly
- `browser-logs` - Read browser errors and exceptions (use recent logs only)
- `search-docs` - Search version-specific Laravel ecosystem documentation (use BEFORE making changes)

**Critical:** Always use `search-docs` for Laravel, Livewire, Filament, and Tailwind questions before implementing features.

## Code Conventions

### PHP
- Use PHP 8 constructor property promotion
- Always use curly braces for control structures (even single line)
- Explicit return type declarations required on all methods
- Type hint method parameters
- Prefer PHPDoc blocks over inline comments
- Enum keys should be TitleCase
- Follow existing code conventions in sibling files

### Database
- Prefer Eloquent relationships over raw queries
- Use `Model::query()` not `DB::`
- Use eager loading to prevent N+1 queries
- When modifying columns in migrations, include ALL previous attributes

### Models
- Use `casts()` method (not `$casts` property) for type casting
- Include return type hints on relationship methods
- Use factories and seeders when creating new models

### Controllers & Validation
- Use Form Request classes (not inline validation)
- Check sibling Form Requests for array vs string validation style
- Follow existing conventions

### Frontend
- Never use `env()` outside config files - use `config()` instead
- Use named routes and `route()` function for URL generation
- Use gap utilities (not margins) for spacing list items
- Support dark mode on new components if existing ones do
- Livewire components require a single root element
- Use `wire:loading` and `wire:dirty` for loading states
- Add `wire:key` to loops

### Routes & Components
- Public pages are full Livewire components (not Blade views with controllers)
- Each Livewire component has a PHP class in `app/Livewire/` and view in `resources/views/livewire/`
- All routes use Livewire component classes directly

## File Creation Workflow

1. **Always use Artisan** to create files (models, controllers, migrations, tests, etc.)
2. Pass `--no-interaction` flag to all Artisan commands
3. For Filament: Use Filament-specific Artisan commands (find with `list-artisan-commands`)
4. Check existing files in the same directory for patterns before creating new ones
5. Reuse existing components before creating new ones

## Important Notes

- Run `vendor/bin/pint --dirty` before finalizing ANY changes
- Every test update should be followed by running that test
- Frontend changes may require `npm run build` or `npm run dev`
- Do not create new base folders without approval
- Do not change dependencies without approval
- Do not remove tests without approval
- Always pass `--no-interaction` to Artisan commands in automation
