<?php

namespace App\Filament\Resources\RequestsActInResource\Pages;

use App\Filament\Resources\RequestsActInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestsActIn extends EditRecord
{
    protected static string $resource = RequestsActInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
