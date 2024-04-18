<?php

namespace App\Filament\StudentOfficer\Resources\RequestActResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActResource;
use App\Models\Accreditation;
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

        $isApproved = Accreditation::where('status', 'approved')->exists();

        $buttonColor = $isApproved ? 'info' : 'gray'; 

        $actions[] = CreateAction::make('reqactin')
            ->label('Create Request')
            ->color($buttonColor)
            ->disabled(!$isApproved)
            ->action(function () use ($isApproved) {
                
                if ($isApproved) {
                    return redirect('/studentOfficer/request-act-offs/index');
                }
            });

        return $actions;
    }
}
