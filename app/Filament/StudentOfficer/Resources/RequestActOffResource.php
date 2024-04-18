<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\StudentOfficer\Resources\RequestActOffResource\Pages;
use App\Filament\StudentOfficer\Resources\RequestActOffResource\RelationManagers;
use App\Models\RequestActOff;
use App\Models\RequestsActOff;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestActOffResource extends Resource
{
    protected static ?string $model = RequestsActOff::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Request For Activity Off-Campus';
    protected static ?string $navigationLabel = 'Request For Activity In-Campus';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()
                    ->label('Title of the Event')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'The Event name already exist.',
                    ]),
                TextInput::make('venues')->required()
                    ->label('Event Venue'),
                    
                FileUpload::make('csw')
                    ->label('Completed Staff Works (CSW)')
                    ->preserveFilenames()
                    ->required(),
                DateTimePicker::make('start_date')
                    ->label('Start Date of the Event')
                    ->required(),
                DateTimePicker::make('end_date')
                    ->label('End Date of the Event')
                    ->required(),
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
                    ->getStateUsing(function (RequestsActOff $record) {
                        $org = $record-> accreditation;

                        return [
                            'org_name_no' => $org -> org_name ?? null,
                        ];
                    }),  
                TextColumn::make('prepared_by')
                    ->label('Submitted By')
                    ->getStateUsing(function (RequestsActOff $record) {
                        $user = $record->user;
                        return [
                            'prepared_by' => $user->name ?? null,
                        ];
                    }),
                TextColumn::make('status')
                    ->badge()  
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
            'index' => Pages\ListRequestActOffs::route('/index'),
            'create' => Pages\CreateRequestActOff::route('/create'),
            'edit' => Pages\EditRequestActOff::route('/{record}/edit'),
            'view' => Pages\ViewActOff::route('/{record}'),
        ];
    }
}
