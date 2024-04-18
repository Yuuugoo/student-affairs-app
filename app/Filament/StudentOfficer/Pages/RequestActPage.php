<?php

namespace App\Filament\StudentOfficer\Pages;

use Filament\Pages\Page;

class RequestActPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationTitle = 'Requests For Activity';
    protected static ?string $title = 'Requests For Activity';
    protected static string $view = 'filament.student-officer.pages.request-act-page';
}
