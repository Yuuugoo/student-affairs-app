<?php

namespace App\Filament\Resources\RequestsReaccredResource\Pages;

use App\Filament\Resources\RequestsReaccredResource;
use App\Models\Reaccreditation;
use App\Models\StudAffairsReaccreditations;
use Filament\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewReaccreds extends ViewRecord
{
    protected static string $resource = RequestsReaccredResource::class;
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
                TextEntry::make('created_at')
                    ->date()
                    ->label('Date Submitted:'),
                TextEntry::make('org_name')
                    ->label('Organization Name')
                    ->getStateUsing(function (StudAffairsReaccreditations $record) {
                        $org = $record-> accreditation;

                        return [
                            'org_name_no' => $org -> org_name ?? null,
                        ];
                    }),  
                TextEntry::make('prepared_by')
                    ->label('Submitted By')
                    ->getStateUsing(function (StudAffairsReaccreditations $record) {
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
                            ->modalHeading('Approve Re-Accreditation Request')
                            ->modalDescription('Are you sure you\'d like to approve this request?')
                            ->action(function ($record) {
                                $record->status = 'approved';
                                $record->remarks = 'All Files are Correct';
                                $record->save();

                                return redirect('/admin/requests-reaccreds/index');
                            }),
                    )
                    ->suffixAction(
                        Action::make('rejected')
                                    ->button()
                                    ->icon('heroicon-o-x-mark')
                                    ->color('danger')
                                    ->requiresConfirmation()
                                    ->modalHeading('Reject Re-Accreditation Request')
                                    ->modalDescription('Are you sure you\'d like to reject this request?')
                                    ->label('Reject')
                                    ->action(function ($record, array $data) {
                                        $record->status = 'rejected';
                                        $remarks = empty(array_filter($data['rejection_reasons'])) ? 'No Remarks' : array_keys(array_filter($data['rejection_reasons']));
                                        $record->remarks = $remarks;
                                        $record->save();
                                
                                        return redirect('/admin/requests-reaccreds/index');
                                    })
                                    ->form([
                                        Checkbox::make('rejection_reasons.missing_ser')
                                            ->label('Missing Student Enrollment Record document.'),
                                        Checkbox::make('rejection_reasons.missing_cog')
                                            ->label('Missing Certification of Grades document.'),
                                        Checkbox::make('rejection_reasons.inc_reqaccred')
                                            ->label('Incomplete Request for Accreditation document.'),
                                        Checkbox::make('rejection_reasons.inc_consbylaws')
                                            ->label('Incomplete Constitutional By Laws document.'),
                                        Checkbox::make('rejection_reasons.inc_proofaccept')
                                            ->label('Incomplete Proof of Acceptance document.'),
                                        Checkbox::make('rejection_reasons.inc_gpoa')
                                            ->label('Incomplete Calendar of Projects document.'),
                                    ])
                    )
            ]),
            Fieldset::make('files')
                    ->label('Files Submitted')
                    ->schema([
                        TextEntry::make('request_for_accred')
                            ->label('Request for Accreditation')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(function (StudAffairsReaccreditations $record) {
                                        return Storage::url($record->request_for_accred);
                                    })
                            ),
                        TextEntry::make('const_by_laws')
                            ->label('Constitutional By Laws')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(function (StudAffairsReaccreditations $record) {
                                        return Storage::url($record->const_by_laws);
                                    })
                            ),
                        TextEntry::make('proof_of_acceptance')
                            ->label('Proof of Acceptance')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(function (StudAffairsReaccreditations $record) {
                                        return Storage::url($record->proof_of_acceptance);
                                    })
                            ),
                        TextEntry::make('calendar_of_projects')
                            ->label('Calendar of Projects')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(function (StudAffairsReaccreditations $record) {
                                        return Storage::url($record->calendar_of_projects);
                                    })
                            ),
                        TextEntry::make('stud_enroll_rec')
                            ->label('Student Enrollement Record')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(function (StudAffairsReaccreditations $record) {
                                        return Storage::url($record->stud_enroll_rec);
                                    })
                            ),
                        TextEntry::make('cert_of_grades')
                            ->label('Certification of Grades')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(function (StudAffairsReaccreditations $record) {
                                        return Storage::url($record->cert_of_grades);
                                    })
                            ),
                            ])
        ]);    
    }


}

