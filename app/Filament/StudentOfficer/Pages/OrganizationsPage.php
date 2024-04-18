<?php

namespace App\Filament\StudentOfficer\Pages;

use Filament\Pages\Page;

class OrganizationsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.student-officer.pages.organizations-page';
}
