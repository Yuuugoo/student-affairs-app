<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\StudentOfficer\Resources\CalendarResource\Pages;
use App\Filament\StudentOfficer\Resources\CalendarResource\RelationManagers;
use App\Models\Calendar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalendarResource extends Resource
{
    protected static ?string $model = Calendar::class;
    protected static ?string $navigationLabel = 'Calendar of Activities';
    protected static ?string $navigationIcon = 'heroicon-m-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                
            ])
            ->bulkActions([
                
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
            'index' => Pages\ListCalendars::route('/'),
            // 'create' => Pages\CreateCalendar::route('/create'),
            // 'edit' => Pages\EditCalendar::route('/{record}/edit'),
        ];
    }
}
