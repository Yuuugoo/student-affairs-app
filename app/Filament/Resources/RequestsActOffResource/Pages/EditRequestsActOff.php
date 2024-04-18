<?php

namespace App\Filament\Resources\RequestsActOffResource\Pages;

use App\Filament\Resources\RequestsActOffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestsActOff extends EditRecord
{
    protected static string $resource = RequestsActOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
