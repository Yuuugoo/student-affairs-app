<?php

namespace App\Filament\StudentOfficer\Resources\OrganizationsResource\Pages;

use App\Filament\StudentOfficer\Resources\OrganizationsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizations extends EditRecord
{
    protected static string $resource = OrganizationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
