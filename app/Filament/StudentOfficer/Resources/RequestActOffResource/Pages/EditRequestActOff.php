<?php

namespace App\Filament\StudentOfficer\Resources\RequestActOffResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActOffResource;
use App\Livewire\CalendarWidget;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestActOff extends EditRecord
{
    protected static string $resource = RequestActOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
