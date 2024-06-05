<?php

namespace App\Filament\StudentOfficer\Pages;

use Filament\Pages\Page;

class BookingCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Book An Event';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.student-officer.pages.booking-calendar';
}
