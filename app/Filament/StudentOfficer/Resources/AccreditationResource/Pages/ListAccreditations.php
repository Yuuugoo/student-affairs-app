<?php

namespace App\Filament\StudentOfficer\Resources\AccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\AccreditationResource;
use App\Models\Accreditation;
use App\Models\StudAffairsAccreditations;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListAccreditations extends ListRecords
{
    protected static string $resource = AccreditationResource::class;
    
    protected function getHeaderActions(): array
    {
        $userId = auth()->id();

        $actions = [];

        if (!StudAffairsAccreditations::where('prepared_by', $userId)->exists()) {
            $actions[] = Actions\CreateAction::make()
                ->label('Create Accreditation Request');
        }

        $isApproved = StudAffairsAccreditations::where('status', 'approved')->exists();

        $buttonColor = $isApproved ? 'success' : 'gray'; 

        $actions[] = Action::make('reaccreditation')
            ->label('Create Re-accreditation Request')
            ->color($buttonColor)
            ->disabled(!$isApproved)
            ->action(function () use ($isApproved) {
                
                if ($isApproved) {
                    return redirect('/studentOfficer/reaccreditations/index');
                }
            });

        return $actions;
    }
}
