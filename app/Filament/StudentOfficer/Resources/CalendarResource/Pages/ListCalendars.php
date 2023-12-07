<?php

namespace App\Filament\StudentOfficer\Resources\CalendarResource\Pages;

use App\Filament\StudentOfficer\Resources\CalendarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCalendars extends ListRecords
{
    protected static string $resource = CalendarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
