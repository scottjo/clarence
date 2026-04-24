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

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4
- filament/filament (FILAMENT) - v5
- laravel/framework (LARAVEL) - v12
- laravel/horizon (HORIZON) - v5
- laravel/prompts (PROMPTS) - v0
- livewire/flux (FLUXUI_FREE) - v2
- livewire/flux-pro (FLUXUI_PRO) - v2
- livewire/livewire (LIVEWIRE) - v4
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- phpunit/phpunit (PHPUNIT) - v11
- tailwindcss (TAILWINDCSS) - v4

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== herd rules ===

# Laravel Herd

- The application is served by Laravel Herd at `https?://[kebab-case-project-dir].test`. Use the `get-absolute-url` tool to generate valid URLs. Never run commands to serve the site. It is always available.
- Use the `herd` CLI to manage services, PHP versions, and sites (e.g. `herd sites`, `herd services:start <service>`, `herd php:list`). Run `herd list` to discover all available commands.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v12 rules ===

# Laravel 12

- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

## Laravel 12 Structure

- In Laravel 12, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app/Console/Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

## Database

- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== phpunit/core rules ===

# PHPUnit

- This application uses PHPUnit for testing. All tests must be written as PHPUnit classes. Use `php artisan make:test --phpunit {name}` to create a new test.
- If you see a test using "Pest", convert it to PHPUnit.
- Every time a test has been updated, run that singular test.
- When the tests relating to your feature are passing, ask the user if they would like to also run the entire test suite to make sure everything is still passing.
- Tests should cover all happy paths, failure paths, and edge cases.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files; these are core to the application.

## Running Tests

- Run the minimal number of tests, using an appropriate filter, before finalizing.
- To run all tests: `php artisan test --compact`.
- To run all tests in a file: `php artisan test --compact tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --compact --filter=testName` (recommended after making a change to a related file).

=== filament/filament rules ===

## Filament

- Filament is a Laravel UI framework built on Livewire, Alpine.js, and Tailwind CSS. UIs are defined in PHP via fluent, chainable components. Follow existing conventions in this app.
- Use the `search-docs` tool for official documentation on Artisan commands, code examples, testing, relationships, and idiomatic practices. If `search-docs` is unavailable, refer to https://filamentphp.com/docs.

### Artisan

- Always use Filament-specific Artisan commands to create files. Find available commands with the `list-artisan-commands` tool, or run `php artisan --help`.
- Inspect required options before running, and always pass `--no-interaction`.

### Patterns

Always use static `make()` methods to initialize components. Most configuration methods accept a `Closure` for dynamic values.

Use `Get $get` to read other form field values for conditional logic:

<code-snippet name="Conditional form field visibility" lang="php">
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;

Select::make('type')
    ->options(CompanyType::class)
    ->required()
    ->live(),

TextInput::make('company_name')
    ->required()
    ->visible(fn (Get $get): bool => $get('type') === 'business'),

</code-snippet>

Use `Set $set` inside `->afterStateUpdated()` on a `->live()` field to mutate another field reactively. Prefer `->live(onBlur: true)` on text inputs to avoid per-keystroke updates:

<code-snippet name="Reactive field update" lang="php">
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

TextInput::make('title')
    ->required()
    ->live(onBlur: true)
    ->afterStateUpdated(fn (Set $set, ?string $state) => $set(
        'slug',
        Str::slug($state ?? ''),
    )),

TextInput::make('slug')
    ->required(),

</code-snippet>

Compose layout by nesting `Section` and `Grid`. Children need explicit `->columnSpan()` or `->columnSpanFull()`:

<code-snippet name="Section and Grid layout" lang="php">
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

Section::make('Details')
    ->schema([
        Grid::make(2)->schema([
            TextInput::make('first_name')
                ->columnSpan(1),
            TextInput::make('last_name')
                ->columnSpan(1),
            TextInput::make('bio')
                ->columnSpanFull(),
        ]),
    ]),

</code-snippet>

Use `Repeater` for inline `HasMany` management. `->relationship()` with no args binds to the relationship matching the field name:

<code-snippet name="Repeater for HasMany" lang="php">
use Filament\Forms\Components\Repeater;

Repeater::make('qualifications')
    ->relationship()
    ->schema([
        TextInput::make('institution')
            ->required(),
        TextInput::make('qualification')
            ->required(),
    ])
    ->columns(2),

</code-snippet>

Use `state()` with a `Closure` to compute derived column values:

<code-snippet name="Computed table column value" lang="php">
use Filament\Tables\Columns\TextColumn;

TextColumn::make('full_name')
    ->state(fn (User $record): string => "{$record->first_name} {$record->last_name}"),

</code-snippet>

Use `SelectFilter` for enum or relationship filters, and `Filter` with a `->query()` closure for custom logic:

<code-snippet name="Table filters" lang="php">
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

SelectFilter::make('status')
    ->options(UserStatus::class),

SelectFilter::make('author')
    ->relationship('author', 'name'),

Filter::make('verified')
    ->query(fn (Builder $query) => $query->whereNotNull('email_verified_at')),

</code-snippet>

Actions are buttons that encapsulate optional modal forms and behavior:

<code-snippet name="Action with modal form" lang="php">
use Filament\Actions\Action;

Action::make('updateEmail')
    ->schema([
        TextInput::make('email')
            ->email()
            ->required(),
    ])
    ->action(fn (array $data, User $record) => $record->update($data)),

</code-snippet>

### Testing

Testing setup (requires `pestphp/pest-plugin-livewire` in `composer.json`):

- Always call `$this->actingAs(User::factory()->create())` before testing panel functionality.
- For edit pages, pass `['record' => $user->id]`, use `->call('save')` (not `->call('create')`), and do not assert `->assertRedirect()` (edit pages do not redirect after save).

<code-snippet name="Table test" lang="php">
use function Pest\Livewire\livewire;

livewire(ListUsers::class)
    ->assertCanSeeTableRecords($users)
    ->searchTable($users->first()->name)
    ->assertCanSeeTableRecords($users->take(1))
    ->assertCanNotSeeTableRecords($users->skip(1));

</code-snippet>

<code-snippet name="Create resource test" lang="php">
use function Pest\Laravel\assertDatabaseHas;

livewire(CreateUser::class)
    ->fillForm([
        'name' => 'Test',
        'email' => 'test@example.com',
    ])
    ->call('create')
    ->assertNotified()
    ->assertHasNoFormErrors()
    ->assertRedirect();

assertDatabaseHas(User::class, [
    'name' => 'Test',
    'email' => 'test@example.com',
]);

</code-snippet>

<code-snippet name="Edit resource test" lang="php">
livewire(EditUser::class, ['record' => $user->id])
    ->fillForm(['name' => 'Updated'])
    ->call('save')
    ->assertNotified()
    ->assertHasNoFormErrors();

assertDatabaseHas(User::class, [
    'id' => $user->id,
    'name' => 'Updated',
]);

</code-snippet>

<code-snippet name="Testing validation" lang="php">
livewire(CreateUser::class)
    ->fillForm([
        'name' => null,
        'email' => 'invalid-email',
    ])
    ->call('create')
    ->assertHasFormErrors([
        'name' => 'required',
        'email' => 'email',
    ])
    ->assertNotNotified();

</code-snippet>

Use `->callAction(DeleteAction::class)` for page actions, or `->callAction(TestAction::make('name')->table($record))` for table actions:

<code-snippet name="Calling actions" lang="php">
use Filament\Actions\Testing\TestAction;

livewire(ListUsers::class)
    ->callAction(TestAction::make('promote')->table($user), [
        'role' => 'admin',
    ])
    ->assertNotified();

</code-snippet>

### Correct Namespaces

- Form fields (`TextInput`, `Select`, `Repeater`, etc.): `Filament\Forms\Components\`
- Infolist entries (`TextEntry`, `IconEntry`, etc.): `Filament\Infolists\Components\`
- Layout components (`Grid`, `Section`, `Fieldset`, `Tabs`, `Wizard`, etc.): `Filament\Schemas\Components\`
- Schema utilities (`Get`, `Set`, etc.): `Filament\Schemas\Components\Utilities\`
- Table columns (`TextColumn`, `IconColumn`, etc.): `Filament\Tables\Columns\`
- Table filters (`SelectFilter`, `Filter`, etc.): `Filament\Tables\Filters\`
- Actions (`DeleteAction`, `CreateAction`, etc.): `Filament\Actions\`. Never use `Filament\Tables\Actions\`, `Filament\Forms\Actions\`, or any other sub-namespace for actions.
- Icons: `Filament\Support\Icons\Heroicon` enum (e.g., `Heroicon::PencilSquare`)

### Common Mistakes

- **Never assume public file visibility.** File visibility is `private` by default. Always use `->visibility('public')` when public access is needed.
- **Never assume full-width layout.** `Grid`, `Section`, `Fieldset`, and `Repeater` do not span all columns by default.
- **Use `Select::make('author_id')->relationship('author', 'name')` for BelongsTo fields.** `BelongsToSelect` does not exist in v4.
- **`Repeater` uses `->schema()`, not `->fields()`.**
- **Never add `->dehydrated(false)` to fields that need to be saved.** It strips the value from form state before `->action()` or the save handler runs. Only use it for helper/UI-only fields.
- **Use correct property types when overriding `Page`, `Resource`, and `Widget` properties.** These properties have union types or changed modifiers that must be preserved:
  - `$navigationIcon`: `protected static string | BackedEnum | null` (not `?string`)
  - `$navigationGroup`: `protected static string | UnitEnum | null` (not `?string`)
  - `$view`: `protected string` (not `protected static string`) on `Page` and `Widget` classes

=== spatie/laravel-medialibrary rules ===

## Media Library

- `spatie/laravel-medialibrary` associates files with Eloquent models, with support for collections, conversions, and responsive images.
- Always activate the `medialibrary-development` skill when working with media uploads, conversions, collections, responsive images, or any code that uses the `HasMedia` interface or `InteractsWithMedia` trait.

</laravel-boost-guidelines>
