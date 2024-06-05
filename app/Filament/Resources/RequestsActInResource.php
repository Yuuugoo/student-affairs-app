<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestsActInResource\Pages;
use App\Filament\Resources\RequestsActInResource\RelationManagers;
use App\Models\RequestsActIn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestsActInResource extends Resource
{
    protected static ?string $model = RequestsActIn::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
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
                    ->dateTime(),
                TextColumn::make('org_name')
                    ->sortable()
                    ->searchable()
                    ->label('Organization Name')
                    ->getStateUsing(function (RequestsActIn $record) {
                        $org = $record-> accreditation;

                        return [
                            'org_name_no' => $org -> org_name ?? null,
                        ];
                    }),  
                TextColumn::make('prepared_by')
                    ->label('Submitted By')
                    ->getStateUsing(function (RequestsActIn $record) {
                        $user = $record->user;
                        return [
                            'prepared_by' => $user->name ?? null,
                        ];
                    }),
                TextColumn::make('status')
                    ->badge()   
            ])
            ->defaultSort('created_at', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Request')
                    ->color('warning'),
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
            'index' => Pages\ListRequestsActIns::route('/index'),
            'view' => Pages\ViewActIn::route('/{record}'),
        ];
    }
}
