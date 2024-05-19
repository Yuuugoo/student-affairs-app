<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class StudentDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $title = 'Welcome to Student Organizations & Activities';
    protected static string $view = 'filament.student.pages.student-dashboard';


}
