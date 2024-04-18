<?php

namespace App\Filament\Resources\RequestsReaccredResource\Pages;

use App\Filament\Resources\RequestsReaccredResource;
use App\Models\Reaccreditation;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditRequestsReaccred extends EditRecord
{
    protected static string $resource = RequestsReaccredResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
