<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\Resources\RequestsResource;
use App\Filament\StudentOfficer\Resources\AccreditationResource\Pages;
use App\Filament\StudentOfficer\Resources\AccreditationResource\RelationManagers;
use App\Models\Accreditation;
use App\Models\Reaccreditation;
use App\Models\RequestsApproval;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccreditationResource extends Resource
{
    protected static ?string $model = Accreditation::class;
    protected static ?string $navigationLabel = 'Accreditation';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('org_name')->required()
                    ->label('Organization Name')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'The Organization Name has already been registered.',
                    ]),
                Section::make()
                    ->schema([
                Repeater::make('list_members_officers')
                    ->schema([
                        TextInput::make('list_members_officers')
                            ->label('Name'),
                        Select::make('role')
                            ->options([
                                'MEMBER' => 'Member',
                                'PRESIDENT' => 'President',
                                'VICE PRESIDENT' => 'Vice President',
                            ]),
                    ])
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
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable(),
                FileUpload::make('const_by_laws')
                    ->label('Constitutional By Laws')
                    ->preserveFilenames(),
                FileUpload::make('proof_of_acceptance')
                    ->label('Proof of Acceptance')
                    ->preserveFilenames(),
                FileUpload::make('calendar_of_projects')
                    ->label('Calendar of Projects')
                    ->preserveFilenames(),
                FileUpload::make('stud_enroll_rec')
                    ->label('Student Enrollement Record')
                    ->preserveFilenames(),
                FileUpload::make('cert_of_grades')
                    ->label('Certification of Grades')
                    ->preserveFilenames(),    
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
                TextColumn::make('org_name')
                    ->sortable()
                    ->searchable()
                    ->label('Organization Name'),    
                TextColumn::make('req_type')
                    ->sortable()
                    ->label('Request Type'),
                TextColumn::make('prepared_by')
                    ->label('Submitted By')
                    ->getStateUsing(function (Accreditation $record) {
                        $user = $record->user;
                    
                        return [
                            'prepared_by' => $user->name ?? null,
                        ];
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()

            ]) ->searchPlaceholder('Search Here')
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

    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function relationManagers(): array
    {
        return [
           
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccreditations::route('/index'),
            'create' => Pages\CreateAccreditation::route('/create'),
            'edit' => Pages\EditAccreditation::route('/{record}/edit'),
        ];
    }
}
