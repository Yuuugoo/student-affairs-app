<?php

namespace App\Filament\StudentOfficer\Resources\AccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\AccreditationResource;
use App\Models\Accreditation;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditAccreditation extends EditRecord
{
    protected static string $resource = AccreditationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('back')
                ->label('Back')
                ->color('amber')
                ->action(function (Accreditation $record) {
                    $record->save();
                    return redirect('/studentOfficer/accreditations/index');
                })
        ];
    }
    
}
