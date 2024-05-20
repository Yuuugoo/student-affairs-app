<?php

namespace App\Filament\Resources\RequestsResource\Pages;

use App\Actions\RequestActions;
use App\Enums\Status;
use App\Filament\Resources\RequestsAccredResource;
use App\Filament\Resources\RequestsResource;
use App\Filament\StudentOfficer\Resources\AccreditationResource;
use App\Models\Accreditation;
use App\Models\RequestsApproval;
use Doctrine\DBAL\Schema\Index;
use Filament\Forms\Components\Builder;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Tables\Actions\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Storage;

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
                                    ->action(function ($record) {
                                        $record->status = 'approved';
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
                                    ->label('Reject')
                                    ->action(function ($record) {
                                        $record->status = 'rejected';
                                        $record->save();

                                        return redirect('/admin/requests-accreds/index');
                                    })
                            ),
                    ]),
            ]);
    }

}
