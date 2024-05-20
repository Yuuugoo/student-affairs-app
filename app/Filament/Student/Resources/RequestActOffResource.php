<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\RequestActOffResource\Pages;
use App\Filament\Student\Resources\RequestActOffResource\RelationManagers;
use App\Models\RequestsActOff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestActOffResource extends Resource
{
    protected static ?string $model = RequestsActOff::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            'index' => Pages\ListRequestActOffs::route('/'),
            'create' => Pages\CreateRequestActOff::route('/create'),
            'edit' => Pages\EditRequestActOff::route('/{record}/edit'),
            'view' => Pages\ViewActOff::route('/{record}'),
        ];
    }
}
