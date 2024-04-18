<?php

namespace App\Filament\StudentOfficer\Resources\AccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\AccreditationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccreditation extends CreateRecord
{
    protected static string $resource = AccreditationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
