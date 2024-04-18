<?php

namespace App\Filament\Resources\RequestsReaccredResource\Pages;

use App\Filament\Resources\RequestsReaccredResource;
use App\Models\Reaccreditation;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListRequestsReaccreds extends ListRecords
{
    protected static string $resource = RequestsReaccredResource::class;

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
