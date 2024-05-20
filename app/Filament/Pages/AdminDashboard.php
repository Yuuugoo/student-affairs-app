<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $title = 'Welcome to Student Organizations & Activities';

    protected static string $view = 'filament.pages.admin-dashboard';
}
