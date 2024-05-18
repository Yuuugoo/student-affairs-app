<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Profile;
use App\Filament\Widgets\AnnouncementsOverview;
use App\Livewire\Swipget as LivewireSwipget;
use App\Livewire\Widgets\Swipget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Widgets;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Rupadana\FilamentSwiper\Infolists\Components\Swiper;
use Rupadana\FilamentSwiper\Widgets\SwiperWidget;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ->brandLogo(asset('images/plm-logo-header.svg'))
            // ->brandLogoHeight('3rem')
            // ->brandLogo(fn () => view('filament.admin.logo'))
            ->darkMode(false)
            ->id('admin')
            ->path('admin')
            ->default()
            ->login()
            ->colors([
                'primary' => '#c6ab5d',
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                LivewireSwipget::class,
                SwiperWidget::class
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
                'admin.email',
            ])
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->config([])
                    ->plugins(['dayGrid', 'timeGrid'])
                    
            );
            
    }
   
}
