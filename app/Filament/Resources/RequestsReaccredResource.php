<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestsReaccredResource\Pages;
use App\Filament\Resources\RequestsReaccredResource\RelationManagers;
use App\Models\Reaccreditation;
use App\Models\RequestsReaccred;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestsReaccredResource extends Resource
{
    protected static ?string $model = Reaccreditation::class;
    protected static bool $shouldRegisterNavigation = false;
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
                //
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
            'index' => Pages\ListRequestsReaccreds::route('/index'),
            'view' => Pages\ViewReaccreds::route('/{record}'),
        ];
    }
}
