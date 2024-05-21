<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages;
use App\Filament\StudentOfficer\Resources\ReaccreditationResource\RelationManagers;
use App\Models\Reaccreditation;
use App\Rules\UniqueRoles;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class ReaccreditationResource extends Resource
{
    protected static ?string $model = Reaccreditation::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    private static $rejectionReasonsMap = [
        'missing_ser' => 'Missing Student Enrollment Record document.',
        'missing_cog' => 'Missing Certification of Grades document.',
        'inc_reqaccred' => 'Incomplete Request for Accreditation document.',
        'inc_consbylaws' => 'Incomplete Constitutional By Laws document.',
        'inc_proofaccept' => 'Incomplete Proof of Acceptance document.',
        'inc_gpoa' => 'Incomplete Calendar of Projects document.',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                Repeater::make('list_members_officers')
                    ->schema([
                        TextInput::make('list_members_officers')
                            ->label('Name')
                            ->required(),
                        Select::make('role')
                            ->options(function ($get) {
                                $roles = collect($get('list_members_officers'))->pluck('role');
                                
                                $roleCounts = $roles->mapToGroups(function ($role) {
                                    return [$role => 1];
                                })->map(function ($items) {
                                    return count($items);
                                });

                                $options = [
                                    'PRESIDENT' => 'President' . ($roleCounts->get('PRESIDENT', 0) >= 1 ? ' (Disabled)' : ''),
                                    'VICE PRESIDENT INTERNAL' => 'Vice President Internal' . ($roleCounts->get('VICE PRESIDENT INTERNAL', 0) >= 1 ? ' (Disabled)' : ''),
                                    'VICE PRESIDENT EXTERNAL' => 'Vice President External' . ($roleCounts->get('VICE PRESIDENT EXTERNAL', 0) >= 1 ? ' (Disabled)' : ''),
                                    'SECRETARY' => 'Secretary' . ($roleCounts->get('SECRETARY', 0) >= 1 ? ' (Disabled)' : ''),
                                    'TREASURER' => 'Treasurer' . ($roleCounts->get('TREASURER', 0) >= 1 ? ' (Disabled)' : ''),
                                    'AUDITOR' => 'Auditor' . ($roleCounts->get('AUDITOR', 0) >= 1 ? ' (Disabled)' : ''),
                                    'PUBLIC RELATION OFFICER' => 'Public Relation Officer' . ($roleCounts->get('PUBLIC RELATION OFFICER', 0) >= 1 ? ' (Disabled)' : ''),
                                    'MEMBER' => 'Member',
                                ];

                                return $options;
                            })
                            ->required(),
                    ])
                    ->rules([
                        function ($get) {
                            return new UniqueRoles($get('list_members_officers'));
                        }
                    ])
                    ->required()
                    ->addActionLabel('Add member')
                    ->columns(2)
                    ->grid(2)
                    ->collapsed()
                    ->label('List of Members')
                    ->minItems(20)
                    ->default([
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                        array_fill(0, 2, null),
                    ]),
                ]),
                FileUpload::make('request_for_accred')
                    ->label('Request for Accreditation')
                    ->downloadable()
                    ->required()
                    ->openable(),
                FileUpload::make('const_by_laws')
                    ->label('Constitutional By Laws')
                    ->downloadable()
                    ->required()
                    ->openable(),
                FileUpload::make('proof_of_acceptance')
                    ->label('Proof of Acceptance')
                    ->downloadable()
                    ->required()
                    ->openable(),
                FileUpload::make('calendar_of_projects')
                    ->label('Calendar of Projects')
                    ->downloadable()
                    ->required()
                    ->openable(),
                FileUpload::make('stud_enroll_rec')
                    ->label('Student Enrollement Record')
                    ->downloadable()
                    ->openable(),
                FileUpload::make('cert_of_grades')
                    ->label('Certification of Grades')
                    ->downloadable()
                    ->openable(),  
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->label('Date')
                    ->date(),
                TextColumn::make('org_name_no')
                    ->sortable()
                    ->searchable()
                    ->label('Organization Name')
                    ->getStateUsing(function (Reaccreditation $record) {
                        $org = $record-> accreditation;

                        return [
                            'org_name_no' => $org -> org_name ?? null,
                        ];
                    }),    
                TextColumn::make('req_type')
                    ->sortable()
                    ->label('Request Type'),
                TextColumn::make('prepared_by')
                    ->label('Submitted By')
                    ->getStateUsing(function (Reaccreditation $record) {
                        $user = $record->user;
                    
                        return [
                            'prepared_by' => $user-> name ?? null,
                        ];
                    })
                    ->searchable(),
                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->getStateUsing(function (Reaccreditation $record) {
                        $remarks = $record->remarks;
                        if (is_array($remarks)) {
                            $mappedRemarks = array_map(function ($code) {
                                return ReaccreditationResource::$rejectionReasonsMap[$code] ?? $code;
                            }, $remarks);
                            return implode(', ', $mappedRemarks);
                        }
                        return $remarks;
                    })
                    ->wrap()
                    ->weight(FontWeight::Bold),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!auth()->user()->is_admin) {
            return $query->where('prepared_by', auth()->user()->id);
        }

        return $query;
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReaccreditations::route('/index'),
            'create' => Pages\CreateReaccreditation::route('/create'),
            'edit' => Pages\EditReaccreditation::route('/{record}/edit'),
        ];
    }
}
