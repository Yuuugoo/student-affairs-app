<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages;
use App\Filament\StudentOfficer\Resources\ReaccreditationResource\RelationManagers;
use App\Models\Reaccreditation;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class ReaccreditationResource extends Resource
{
    protected static ?string $model = Reaccreditation::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                            ->options([
                                'MEBER' => 'Member',
                                'PRESIDENT' => 'President',
                                'VICE PRESIDENT' => 'Vice President',
                            ])
                    ])->addActionLabel('Add member')
                    ->columns(2)
                    ->grid(2)
                    ->collapsible()
                    ->label('List of Members'),
                ]),
                FileUpload::make('request_for_accred')
                    ->label('Request for Accreditation')
                    ->preserveFilenames(),
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
