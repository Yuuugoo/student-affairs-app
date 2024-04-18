<?php

namespace App\Filament\StudentOfficer\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class StudentOfficerDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.student-officer.pages.student-officer-dashboard';

    public function getHeader(): ?View
    {
        return view('filament.settings.custom-header');
    }


}
