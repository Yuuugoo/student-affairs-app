<?php

namespace App\Filament\StudentOfficer\Resources\RequestActResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActResource;
use App\Models\Accreditation;
use App\Models\StudAffairsAccreditations;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRequestActs extends ListRecords
{
    protected static string $resource = RequestActResource::class;

    protected function getHeaderActions(): array
    {
        $userId = auth()->id();

        $actions = [];
        $actions = [Action::make('back')
        ->label('Back')
        ->color('warning')
        ->action(function () {
            
            return redirect('/studentOfficer/request-act-page');
        })];

        $isApproved = StudAffairsAccreditations::where('status', 'approved')->exists();
        $redirectUrl = $isApproved ? '/studentOfficer/booking-calendar' : '/studentOfficer/booking-calendar';
        $buttonColor = $isApproved ? 'info' : 'gray'; 

        $actions[] = CreateAction::make('reqactin')
            ->label('Create Request')
            ->color($buttonColor)
            ->disabled(!$isApproved)
            ->url($redirectUrl);

        return $actions;
    }
}
