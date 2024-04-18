<?php

namespace App\Filament\StudentOfficer\Resources\CalendarResource\Pages;

use App\Filament\StudentOfficer\Resources\CalendarResource;
use Filament\Resources\Pages\Page;

class CreateAct extends Page
{
    protected static string $resource = CalendarResource::class;
    protected static ?string $title = 'Schedule an Activity';
    protected static string $view = 'filament.student-officer.resources.calendar-resource.pages.create-act';

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }
}
