<?php

namespace App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\ReaccreditationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReaccreditation extends EditRecord
{
    protected static string $resource = ReaccreditationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
