<?php

namespace App\Filament\Resources\RequestsActOffResource\Pages;

use App\Filament\Resources\RequestsActOffResource;
use App\Models\Accreditation;
use App\Models\RequestsActIn;
use App\Models\RequestsActOff;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewActOff extends ViewRecord
{
    protected static string $resource = RequestsActOffResource::class;
    protected static array $statuses = [
        'approved' => 'Approve',
        'rejected' => 'Reject'
    ];

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Section::make('Activity Details')
            ->schema([
                TextEntry::make('title')
                    ->label('Title of the Event:'),
                TextEntry::make('created_at')
                    ->date()
                    ->label('Date Submitted:'),
                TextEntry::make('org_name_no')
                    ->label('Organization Name:')
                    ->getStateUsing(function (RequestsActOff $record) {
                        $org = $record-> accreditation;

                        return [
                            'org_name_no' => $org -> org_name ?? null,
                        ];
                    }),
                TextEntry::make('prepared_by')
                    ->label('Submitted By:')
                    ->getStateUsing(function (RequestsActOff $record) {
                        $user = $record->user;
                        return [
                            'prepared_by' => $user->name ?? null,
                        ];
                    }),
                TextEntry::make('status')
                    ->label('Status:')
                    ->badge()
                    ->suffixAction(
                        Action::make('approved')
                            ->button()
                            ->icon('heroicon-s-check')
                            ->color('success')
                            ->label('Approve')
                            ->action(function (RequestsActOff $record) {
                                $record->status = 'approved';
                                $record->save();

                                return redirect('/admin/requests-act-offs/index');
                            }),
                    )
                    ->suffixAction(
                        Action::make('rejected')
                            ->button()
                            ->icon('heroicon-o-x-mark')
                            ->color('danger')
                            ->label('Reject')
                            ->action(function (RequestsActOff $record) {
                                $record->status = 'rejected';
                                $record->save();

                                return redirect('/admin/requests-act-offs/index');
                            })
                    )
            ]),
            Fieldset::make('files')
                    ->label('Files Submitted')
                    ->schema([
                        TextEntry::make('csw')
                            ->label('Request for Accreditation')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(function (RequestsActOff $record) {
                                        return Storage::url($record->csw);
                                    })
                            ),
            
                    ])
        ]);    
    }


}

