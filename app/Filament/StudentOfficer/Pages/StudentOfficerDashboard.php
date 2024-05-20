<?php

namespace App\Filament\StudentOfficer\Pages;

use Filament\Pages\Page;

class StudentOfficerDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $title = 'Welcome to Student Organizations & Activities';
    protected static string $view = 'filament.student-officer.pages.student-officer-dashboard';

    
}
