<?php

namespace App\Filament\StudentOfficer\Resources\AccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\AccreditationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccreditations extends ListRecords
{
    protected static string $resource = AccreditationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
