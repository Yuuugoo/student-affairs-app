<?php

namespace App\Filament\StudentOfficer\Resources\RequestActResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequestActs extends ListRecords
{
    protected static string $resource = RequestActResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create New Request'),
        ];
    }
}
