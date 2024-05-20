<?php

namespace App\Filament\Student\Resources\RequestActResource\Pages;

use App\Filament\Student\Resources\RequestActResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequestActs extends ListRecords
{
    protected static string $resource = RequestActResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
