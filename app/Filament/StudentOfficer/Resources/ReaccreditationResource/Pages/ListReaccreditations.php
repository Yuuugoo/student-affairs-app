<?php

namespace App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\ReaccreditationResource;
use App\Models\Reaccreditation;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListReaccreditations extends ListRecords
{
    protected static string $resource = ReaccreditationResource::class;

    protected function getHeaderActions(): array
    {
        
        $userId = auth()->id();

        $actions = [Action::make('back')
        ->label('Back')
        ->color('warning')
        ->action(function () {
            
            return redirect('/studentOfficer/accreditations/index');
        })];

        if (!Reaccreditation::where('prepared_by', $userId)->exists()) {
            $actions[] = Actions\CreateAction::make()
                ->label('Create Accreditation Request');
        }
        
        return $actions;
    }
}
