<?php

namespace App\Filament\StudentOfficer\Resources\RequestActOffResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActOffResource;
use App\Livewire\CalendarWidget;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequestActOff extends CreateRecord
{
    protected static string $resource = RequestActOffResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
