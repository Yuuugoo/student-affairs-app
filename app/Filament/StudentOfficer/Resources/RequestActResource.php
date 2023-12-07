<?php

namespace App\Filament\StudentOfficer\Resources;

use App\Filament\StudentOfficer\Resources\RequestActResource\Pages;
use App\Filament\StudentOfficer\Resources\RequestActResource\RelationManagers;
use App\Models\Requests;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestActResource extends Resource
{
    protected static ?string $model = Requests::class;
    protected static ?string $navigationLabel = 'Request For Activity';
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static array $statuses = [
        'approved' => 'Approve',
        'rejected' => 'Reject'
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('org_name')->required()
                    ->label('Organization Name'),
                TextInput::make('type')->required(),
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
                    ->searchable()
                    ->label('Organization Name'),
                TextColumn::make('submitted_by')
                    ->searchable()
                    ->label('Submitted By')
                    ->getStateUsing(function (Requests $record) {
                        $user = $record->user;
                    
                        return [
                            'submitted_by' => $user->name ?? null,
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
            'index' => Pages\ListRequestActs::route('/index'),
            'create' => Pages\CreateRequestAct::route('/create'),
            'edit' => Pages\EditRequestAct::route('/{record}/edit'),
        ];
    }
}
