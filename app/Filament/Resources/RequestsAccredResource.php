<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestsResource\Pages;
use App\Filament\Resources\RequestsResource\RelationManagers;
use App\Models\Accreditation;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;


class RequestsAccredResource extends Resource
{

    protected static ?string $model = Accreditation::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationLabel = 'Requests';
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/index'),
            'view' => Pages\ViewRequest::route('/{record}'),
        ];
    }
}
