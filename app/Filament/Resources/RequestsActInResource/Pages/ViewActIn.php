<?php

namespace App\Filament\Resources\RequestsActInResource\Pages;

use App\Filament\Resources\RequestsActInResource;
use App\Models\RequestsActIn;
use Filament\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewActIn extends ViewRecord
{
    protected static string $resource = RequestsActInResource::class;
    protected static array $statuses = [
        'approved' => 'Approve',
        'rejected' => 'Reject'
    ];

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Split::make([
            Tabs::make('Activity Details')
                ->tabs([
                    Tab::make('Request Details')
                    ->schema([
                        TextEntry::make('created_at')
                            ->date()
                            ->label('Date Submitted:'),
                        TextEntry::make('org_name_no')
                            ->label('Organization Name:')
                            ->getStateUsing(function (RequestsActIn $record) {
                                $org = $record-> accreditation;

                                return [
                                    'org_name_no' => $org -> org_name ?? null,
                                ];
                        }),
                        TextEntry::make('prepared_by')
                            ->label('Submitted By:')
                            ->getStateUsing(function (RequestsActIn $record) {
                                $user = $record->user;
                                return [
                                    'prepared_by' => $user->name ?? null,
                                ];
                        }),
                    ]),
                    Tab::make('Event Details')
                    ->schema([
                        TextEntry::make('venues')
                            ->label('Event Venue:'),
                        TextEntry::make('start_date')
                            ->label('Start Date of the Event:'),
                        TextEntry::make('end_date')
                            ->label('End Date of the Event:'),
                        TextEntry::make('participants_no')
                            ->label('Number of Participants:'),
                    ]),
        
            ]),
            Section::make('Status')
                ->label('Status')
                ->schema([
                    TextEntry::make('status')
                            ->label('')
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

                                        return redirect('/admin/requests-act-ins/index');
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
                                
                                        return redirect('/admin/requests-act-ins/index');
                                    })
                                    ->form([
                                        Checkbox::make('rejection_reasons.unavailable_venue')
                                            ->label('The Selected Date and Venue was already Booked'),
                                        Checkbox::make('rejection_reasons.incompletecsw')
                                            ->label('Incomplete Completed Staff Works Document'),
                                    ])
                            )
                ])->grow(false),

            ])->from('2xl'),
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
                                    ->url(function (RequestsActIn $record) {
                                        return Storage::url($record->csw);
                                    })
                            ),
                    ])
        ]);    
    }
}
