<?php

namespace App\Filament\Resources\RequestsResource\Pages;

use App\Filament\Resources\RequestsAccredResource;
use App\Models\RequestsActIn;
use App\Models\RequestsActOff;
use App\Models\Reaccreditation;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListRequests extends ListRecords
{
    protected static string $resource = RequestsAccredResource::class;
    
    protected function getHeaderActions(): array
    {
        $offCampusCount = RequestsActOff::where('status', '!=', 'approved')->count();
        $inCampusCount = RequestsActIn::where('status', '!=', 'approved')->count();
        $reaccreditationCount = Reaccreditation::where('status', '!=', 'approved')->count();
        
        $actions = [];

        $actions[] = Action::make('off_campus')
            ->label("Act Off-Campus Requests " . ($offCampusCount > 0 ? "({$offCampusCount})" : ''))
            ->color('warning')
            ->action(function () {
                return redirect('/admin/requests-act-offs/index');
            });

        $actions[] = Action::make('in_campus')
            ->label("Act In-Campus Requests " . ($inCampusCount > 0 ? "({$inCampusCount})" : ''))
            ->color('warning')
            ->action(function () {
                return redirect('/admin/requests-act-ins/index');
            });

        $actions[] = Action::make('reaccreditation')
            ->label("Reaccreditation Requests " . ($reaccreditationCount > 0 ? "({$reaccreditationCount})" : ''))
            ->color('warning')
            ->action(function () {
                return redirect('/admin/requests-reaccreds/index');
            });

        return $actions;
    }
}
