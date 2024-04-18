<?php

namespace App\Filament\Resources\RequestsActOffResource\Pages;

use App\Filament\Resources\RequestsActOffResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListRequestsActOffs extends ListRecords
{
    protected static string $resource = RequestsActOffResource::class;

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
