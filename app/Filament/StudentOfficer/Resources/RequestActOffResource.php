<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\StudentOfficer\Resources\RequestActOffResource\Pages;
use App\Filament\StudentOfficer\Resources\RequestActOffResource\RelationManagers;
use App\Models\RequestActOff;
use App\Models\RequestsActOff;
use App\Models\StudAffairsRequestsactoffs;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
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

class RequestActOffResource extends Resource
{
    protected static ?string $model = StudAffairsRequestsactoffs::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Request For Activity Off-Campus';
    protected static ?string $navigationLabel = 'Request For Activity In-Campus';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    private static $rejectionReasonsMap = [
        'unavailable_venue' => 'The Selected Date and Venue was unavailable',
        'incompletecsw' => 'Incomplete Completed Staff Works Document',
    ];

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
                TextInput::make('participants_no')->required()
                    ->label('Enter Number of Participants: ')
                    ->integer()
                    ->minValue(1),
                FileUpload::make('csw')
                    ->label('Completed Staff Works (CSW)')
                    ->downloadable()
                    ->required()
                    ->openable(),
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
                    ->getStateUsing(function (StudAffairsRequestsactoffs $record) {
                        $org = $record-> accreditation;

                        return [
                            'org_name_no' => $org -> org_name ?? null,
                        ];
                    }),  
                TextColumn::make('prepared_by')
                    ->label('Submitted By')
                    ->getStateUsing(function (StudAffairsRequestsactoffs $record) {
                        $user = $record->user;
                        return [
                            'prepared_by' => $user->name ?? null,
                        ];
                    }),
                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->getStateUsing(function (StudAffairsRequestsactoffs $record) {
                        $remarks = $record->remarks;
                        if (is_array($remarks)) {
                            $mappedRemarks = array_map(function ($code) {
                                return RequestActOffResource::$rejectionReasonsMap[$code] ?? $code;
                            }, $remarks);
                            return implode(', ', $mappedRemarks);
                        }
                        return $remarks;
                    })
                    ->wrap()
                    ->weight(FontWeight::Bold),
                TextColumn::make('status')
                    ->badge()  
            ])
            ->filters([
                
            ])
            ->actions([
                
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
            'index' => Pages\ListRequestActOffs::route('/index'),
            'create' => Pages\CreateRequestActOff::route('/create'),
            'view' => Pages\ViewActOff::route('/{record}'),
        ];
    }
}
