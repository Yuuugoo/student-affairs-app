<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CalendarActs extends Page
{
    protected static ?string $navigationLabel = 'Calendar of Activities';
    protected static ?string $navigationIcon = 'heroicon-m-calendar-days';
    protected static string $view = 'filament.pages.calendar-acts';
}
