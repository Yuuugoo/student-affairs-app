<?php

namespace App\Filament\StudentOfficer\Resources\RequestActResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActResource;
use App\Livewire\CalendarWidget;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequestAct extends CreateRecord
{
    protected static string $resource = RequestActResource::class;

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
