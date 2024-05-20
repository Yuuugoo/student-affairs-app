<?php

namespace App\Filament\Student\Resources\RequestActOffResource\Pages;

use App\Filament\Student\Resources\RequestActOffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequestActOffs extends ListRecords
{
    protected static string $resource = RequestActOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
