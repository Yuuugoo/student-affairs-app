<?php

namespace App\Filament\Resources\RequestsActOffResource\Pages;

use App\Filament\Resources\RequestsActOffResource;
use App\Models\Accreditation;
use App\Models\RequestsActIn;
use App\Models\RequestsActOff;
use App\Models\StudAffairsRequestsactoffs;
use Filament\Actions;
use Filament\Forms\Components\Checkbox;
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
                    ->getStateUsing(function (StudAffairsRequestsactoffs $record) {
                        $org = $record-> accreditation;

                        return [
                            'org_name_no' => $org -> org_name ?? null,
                        ];
                    }),
                TextEntry::make('prepared_by')
                    ->label('Submitted By:')
                    ->getStateUsing(function (StudAffairsRequestsactoffs $record) {
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
                                    ->requiresConfirmation()
                                    ->modalIcon('heroicon-o-document-check')
                                    ->modalHeading('Approve Activity for In-Campus Request')
                                    ->modalDescription('Are you sure you\'d like to approve this request?')
                                    ->action(function ($record) {
                                        $record->status = 'approved';
                                        $record->remarks = 'No Remarks';
                                        $record->save();

                                        return redirect('/admin/requests-act-offs/index');
                                    }),
                    )
                    ->suffixAction(
                        Action::make('rejected')
                                    ->button()
                                    ->icon('heroicon-o-x-mark')
                                    ->color('danger')
                                    ->requiresConfirmation()
                                    ->modalHeading('Reject Activity for In-Campus Request')
                                    ->modalDescription('Are you sure you\'d like to reject this request?')
                                    ->label('Reject')
                                    ->action(function ($record, array $data) {
                                        $record->status = 'rejected';
                                        $remarks = empty(array_filter($data['rejection_reasons'])) ? 'No Remarks' : array_keys(array_filter($data['rejection_reasons']));
                                        $record->remarks = $remarks;
                                        $record->save();
                                
                                        return redirect('/admin/requests-act-offs/index');
                                    })
                                    ->form([
                                        Checkbox::make('rejection_reasons.unavailable_venue')
                                            ->label('The Selected Date and Venue was unavailable'),
                                        Checkbox::make('rejection_reasons.incompletecsw')
                                            ->label('Incomplete Completed Staff Works Document'),
                                    ])
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
                                    ->url(function (StudAffairsRequestsactoffs $record) {
                                        return Storage::url($record->csw);
                                    })
                            ),
            
                    ])
        ]);    
    }


}

