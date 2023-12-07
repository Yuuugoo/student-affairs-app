<?php

namespace App\Filament\StudentOfficer\Resources\CalendarResource\Pages;

use App\Filament\StudentOfficer\Resources\CalendarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCalendar extends EditRecord
{
    protected static string $resource = CalendarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
