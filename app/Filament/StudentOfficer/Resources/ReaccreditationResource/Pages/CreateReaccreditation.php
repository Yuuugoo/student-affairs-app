<?php

namespace App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\ReaccreditationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReaccreditation extends CreateRecord
{
    protected static string $resource = ReaccreditationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
