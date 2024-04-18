<?php

namespace App\Filament\Resources\RequestsActInResource\Pages;

use App\Filament\Resources\RequestsActInResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListRequestsActIns extends ListRecords
{
    protected static string $resource = RequestsActInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->color('warning')
                ->action(function () {
                    
                    return redirect('/admin/requests-accreds/index');
                })
        ];
    }
}
