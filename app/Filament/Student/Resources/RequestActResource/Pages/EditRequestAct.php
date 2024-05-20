<?php

namespace App\Filament\Student\Resources\RequestActResource\Pages;

use App\Filament\Student\Resources\RequestActResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestAct extends EditRecord
{
    protected static string $resource = RequestActResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
