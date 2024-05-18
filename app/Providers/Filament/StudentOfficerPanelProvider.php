<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AnnouncementsOverview;
use App\Livewire\CalendarWidget;
use App\Livewire\Swipget as LivewireSwipget;
use App\Livewire\Widgets\Swipget;
use App\Models\Announcement;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Pages\Auth\EditProfile;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class StudentOfficerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ->brandLogo(asset('images/plm-logo-header.svg'))
            // ->brandLogoHeight('3rem')
            ->login()
            ->darkMode(false)
            ->registration()
            ->profile(EditProfile::class)
            ->id('studentOfficer')
            ->path('studentOfficer')
            ->colors([
                'primary' => '#c6ab5d',
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/StudentOfficer/Resources'), for: 'App\\Filament\\StudentOfficer\\Resources')
            ->discoverPages(in: app_path('Filament/StudentOfficer/Pages'), for: 'App\\Filament\\StudentOfficer\\Pages')
            ->pages([
                
            ])
            ->discoverWidgets(in: app_path('Filament/StudentOfficer/Widgets'), for: 'App\\Filament\\StudentOfficer\\Widgets')
            ->widgets([
                LivewireSwipget::class
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
                

            ])
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->config([])
                    ->plugins(['dayGrid', 'timeGrid'])
                    ->selectable()
                    
            );
    }
}
