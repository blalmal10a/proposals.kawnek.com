<?php

namespace App\Providers\Filament;

use App\Filament\SelectFeature\Pages\HomePage;
use App\Livewire\LandingPage;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SelectFeaturePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('selectFeature')
            ->path('')
            ->colors([
                'primary' => Color::Rose,
            ])
            ->navigationItems(
                [
                    NavigationItem::make('Admin')
                        ->hidden(fn() => ! Auth::check())
                        ->sort(3)
                        ->icon(Heroicon::ShieldCheck)
                        ->url('/admin')
                ]
            )
            ->globalSearch(false)
            ->discoverResources(in: app_path('Filament/SelectFeature/Resources'), for: 'App\Filament\SelectFeature\Resources')
            ->discoverPages(in: app_path('Filament/SelectFeature/Pages'), for: 'App\Filament\SelectFeature\Pages')
            ->pages([
                // Dashboard::class,
                HomePage::class
            ])
            ->discoverWidgets(in: app_path('Filament/SelectFeature/Widgets'), for: 'App\Filament\SelectFeature\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
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
                // Authenticate::class,
            ]);
    }
}
