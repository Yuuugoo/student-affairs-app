<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\RequestActResource\Pages;
use App\Filament\Student\Resources\RequestActResource\RelationManagers;
use App\Models\RequestAct;
use App\Models\RequestsActIn;
use App\Models\StudAffairsRequestsactins;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestActResource extends Resource
{
    protected static ?string $model = StudAffairsRequestsactins::class;
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
            'index' => Pages\ListRequestActs::route('/'),
            'create' => Pages\CreateRequestAct::route('/create'),
            'edit' => Pages\EditRequestAct::route('/{record}/edit'),
            'view' => Pages\ViewActIn::route('/{record}'),
        ];
    }
}
