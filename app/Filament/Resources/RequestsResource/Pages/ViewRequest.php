<?php

namespace App\Filament\Resources\RequestsResource\Pages;

use App\Actions\RequestActions;
use App\Enums\Status;
use App\Filament\Resources\RequestsResource;
use App\Models\Requests;
use Doctrine\DBAL\Schema\Index;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions\Action;

class ViewRequest extends ViewRecord
{
    protected static string $resource = RequestsResource::class;
    protected static array $statuses = [
        'approved' => 'Approve',
        'rejected' => 'Reject'
    ];

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('created_at')
                    ->date()
                    ->label('Date Submitted:'),
                TextEntry::make('org_name')
                    ->label('Organization Name:'),
                TextEntry::make('submitted_by')
                    ->label('Submitted By:'),
                TextEntry::make('status')
                    ->label('Status:')
                    ->badge()
                    ->suffixAction(
                        Action::make('approved')
                            ->button()
                            ->icon('heroicon-s-check')
                            ->color('success')
                            ->label('Approve')
                            ->action(function (Requests $record) {
                                $record->status = 'approved';
                                $record->save();

                                return redirect('/admin/requests/index');
                            }),
                    )
                    ->suffixAction(
                        Action::make('rejected')
                            ->button()
                            ->icon('heroicon-o-x-mark')
                            ->color('danger')
                            ->label('Reject')
                            ->action(function (Requests $record) {
                                $record->status = 'rejected';
                                $record->save();

                                return redirect('/admin/requests/index');
                            })
                    )
                
            ]);
    }

}