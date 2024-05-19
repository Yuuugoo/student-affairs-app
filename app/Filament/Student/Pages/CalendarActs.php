<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class CalendarActs extends Page
{

    protected static ?string $navigationLabel = 'Calendar of Activities';
    protected static ?string $navigationIcon = 'heroicon-m-calendar-days';
    protected static ?string $title = 'Calendar of Activities';
    protected static string $view = 'filament.student.pages.calendar-acts';
    protected static ?int $navigationSort = 2;
}
