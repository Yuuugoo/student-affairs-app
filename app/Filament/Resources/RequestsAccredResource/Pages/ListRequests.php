<?php

namespace App\Filament\Resources\RequestsResource\Pages;

use App\Filament\Resources\RequestsAccredResource;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListRequests extends ListRecords
{
    protected static string $resource = RequestsAccredResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('off_campus')
                ->label('Act Off-Campus Requests')
                ->color('warning')
                ->action(function () {
                    return redirect('/admin/requests-act-offs/index');
                }),
            Action::make('in_campus')
                ->label('Act In-Campus Requests')
                ->color('warning')
                ->action(function () {
                    return redirect('/admin/requests-act-ins/index');
                }),
            Action::make('reaccreditation')
                ->label('Reaccreditation Requests')
                ->color('warning')
                ->action(function () {
                    return redirect('/admin/requests-reaccreds/index');
                })
        ];
    }
}
