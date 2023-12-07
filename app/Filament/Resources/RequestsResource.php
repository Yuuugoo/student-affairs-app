<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestsResource\Pages;
use App\Filament\Resources\RequestsResource\RelationManagers;
use App\Models\Requests;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestsResource extends Resource
{
    protected static ?string $model = Requests::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static array $statuses = [
        'approved' => 'Approve',
        'rejected' => 'Reject'
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->label('Date')
                    ->date(),
                TextColumn::make('org_name')
                    ->searchable()
                    ->label('Organization Name'),
                TextColumn::make('Submitted By')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Requests $record) {
                        $user = $record->user;
                    
                        return [
                            'submitted_by' => $user->name ?? null,
                        ];
                    }),
                TextColumn::make('status')
                    ->badge()
                    
            ]) ->searchPlaceholder('Search Here')
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
            'index' => Pages\ListRequests::route('/index'),
            'view' => Pages\ViewRequest::route('/{record}'),
        ];
    }
}
