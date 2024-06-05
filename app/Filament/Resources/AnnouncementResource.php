<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use App\Models\StudAffairsAnnouncement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnnouncementResource extends Resource
{
    protected static ?string $model = StudAffairsAnnouncement::class;
    protected static ?string $navigationLabel = 'Create Announcements';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')->required(),
                        Forms\Components\Textarea::make('description'),
                        TextInput::make('content')
                            ->label('Content Link')
                            ->required(),
                        Toggle::make('publish')->required()
                            ->onColor('warning')
                            ->offColor('danger')->afterStateUpdated(function (Set $set, bool $state) {
                                $set('publish', $state);
                            }),
                        FileUpload::make('image_preview')->required()
                            ->preserveFilenames()
                            ->image()
                            ->imageEditor(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('description')
                    ->wrap(),
                ImageColumn::make('image_preview'),
                IconColumn::make('publish')
                    ->label('Published')
                    ->boolean()
                    ->trueColor('warning')
                    ->falseColor('danger'),

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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}