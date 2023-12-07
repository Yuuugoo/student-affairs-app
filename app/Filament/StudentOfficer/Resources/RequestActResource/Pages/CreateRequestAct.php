<?php

namespace App\Filament\StudentOfficer\Resources\RequestActResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequestAct extends CreateRecord
{
    protected static string $resource = RequestActResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
