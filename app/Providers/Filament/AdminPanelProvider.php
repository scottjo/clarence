<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use RalphJSmit\Filament\MediaLibrary\Filament\Pages\MediaLibrary as MediaLibraryPage;
use RalphJSmit\Filament\MediaLibrary\FilamentMediaLibrary;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->path(config('filament.admin_path', 'admin'))
            ->brandName('Clarence Bowling Club')
            ->login()
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Media'),
                NavigationGroup::make()
                    ->label('Content'),
                NavigationGroup::make()
                    ->label('Configuration'),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugins([
                FilamentSpatieLaravelHealthPlugin::make()
                    ->authorize(fn () => auth()->user()?->isSuperUser())
                    ->navigationGroup('Monitoring'),
                FilamentMediaLibrary::make()
                    ->registerNavigation(false)
                    ->acceptImage(false)
                    ->additionalAcceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'image/svg+xml',
                        'image/gif',
                    ])
                    ->acceptPdf()
                    ->acceptAudio()
                    ->acceptZip()
                    ->acceptMicrosoftWord()
                    ->acceptMicrosoftExcel()
                    ->acceptMicrosoftPowerpoint()
                    ->acceptCsv()
                    ->conversions(),
            ])
            ->navigationItems([
                NavigationItem::make('Media Library')
                    ->group('Media')
                    ->icon(Heroicon::Photo)
                    ->visible(fn (): bool => auth()->user()?->isMediaUser() ?? false)
                    ->url(fn (): string => MediaLibraryPage::getUrl()),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
