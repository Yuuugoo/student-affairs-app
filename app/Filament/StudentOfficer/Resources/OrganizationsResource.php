<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\StudentOfficer\Resources\OrganizationsResource\Pages;
use App\Filament\StudentOfficer\Resources\OrganizationsResource\RelationManagers;
use App\Models\Organizations;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationsResource extends Resource
{
    protected static ?string $model = Organizations::class;
    protected static ?string $navigationLabel = 'PLM Organizations';
    protected static ?string $navigationIcon = 'icomoon-tree';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             //
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->actions([

    //         ])
    //         ->bulkActions([
        
    //         ]);
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            // 'create' => Pages\CreateOrganizations::route('/create'),
            // 'edit' => Pages\EditOrganizations::route('/{record}/edit'),
        ];
    }
}
