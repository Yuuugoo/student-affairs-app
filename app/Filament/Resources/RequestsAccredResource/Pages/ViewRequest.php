<?php

namespace App\Filament\Resources\RequestsResource\Pages;


use App\Filament\Resources\RequestsAccredResource;
use Filament\Forms\Components\Checkbox;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ViewRequest extends ViewRecord
{   
    protected static string $resource = RequestsAccredResource::class;


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
                    Section::make('Organization Details')
                        ->schema([
                            TextEntry::make('created_at')
                                ->date()
                                ->icon('heroicon-s-calendar-days')
                                ->label('Date Submitted:'),
                            TextEntry::make('org_name')
                                ->icon('heroicon-s-rectangle-group')
                                ->label('Organization Name:'),
                            TextEntry::make('prepared_by')
                                ->icon('heroicon-s-user')
                                ->label('Submitted By:')
                                ->getStateUsing(function ($record) {
                                    return [
                                        'prepared_by' => $record->user->name ?? null,
                                    ];
                                }),
                        ]),
                    Section::make('List of Members')
                        ->schema([
                            TextEntry::make('list_members_officers')
                                ->label('')
                                ->getStateUsing(function ($record) {
                                    $members = $record->list_members_officers ?? [];
                                    return view('filament.resources.list-table', ['members' => $members])->render();
                                })
                                ->html(),
                            ])
                            ->grow(false)
                            ->collapsed()
                            ->collapsible(),  
                ])->from('2xl'),                  
                Fieldset::make('files')
                    ->label('Files Submitted')
                    ->schema([
                        TextEntry::make('request_for_accred')
                            ->label('Request for Accreditation:')
                            ->icon('heroicon-m-folder')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(fn($record) => Storage::url($record->request_for_accred))
                            ),
                        TextEntry::make('const_by_laws')
                            ->label('Constitutional By Laws:')
                            ->icon('heroicon-m-folder')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(fn($record) => Storage::url($record->const_by_laws))
                            ),
                        TextEntry::make('proof_of_acceptance')
                            ->label('Proof of Acceptance:')
                            ->icon('heroicon-m-folder')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(fn($record) => Storage::url($record->proof_of_acceptance))
                            ),
                        TextEntry::make('calendar_of_projects')
                            ->label('Calendar of Projects:')
                            ->icon('heroicon-m-folder')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(fn($record) => Storage::url($record->calendar_of_projects))
                            ),
                        TextEntry::make('stud_enroll_rec')
                            ->label('Student Enrollment Record:')
                            ->icon('heroicon-m-folder')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(fn($record) => Storage::url($record->stud_enroll_rec))
                            ),
                        TextEntry::make('cert_of_grades')
                            ->label('Certification of Grades:')
                            ->icon('heroicon-m-folder')
                            ->suffixAction(
                                Action::make('download')
                                    ->label('View')
                                    ->button()
                                    ->icon('heroicon-s-eye')
                                    ->url(fn($record) => Storage::url($record->cert_of_grades))
                            ),
                    ]),

                    Section::make()
                    ->schema([
                        
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
                                    ->modalHeading('Approve Accreditation Request')
                                    ->modalDescription('Are you sure you\'d like to approve this request?')
                                    ->action(function ($record) {
                                        $record->status = 'approved';
                                        $record->remarks = 'All Files are Correct';
                                        $record->save();

                                        return redirect('/admin/requests-accreds/index');
                                    }),
                            )
                            ->suffixAction(
                                Action::make('rejected')
                                    ->button()
                                    ->icon('heroicon-o-x-mark')
                                    ->color('danger')
                                    ->requiresConfirmation()
                                    ->modalHeading('Reject Accreditation Request')
                                    ->modalDescription('Are you sure you\'d like to reject this request?')
                                    ->label('Reject')
                                    ->action(function ($record, array $data) {
                                        $record->status = 'rejected';
                                        $remarks = empty(array_filter($data['rejection_reasons'])) ? 'No Remarks' : array_keys(array_filter($data['rejection_reasons']));
                                        $record->remarks = $remarks;
                                        $record->save();
                                
                                        return redirect('/admin/requests-accreds/index');
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
                            ),
                    ]),
            ]);
    }

}
