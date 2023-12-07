<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Infolists\Infolist;
use Rupadana\FilamentSwiper\Infolists\Components\SwiperImageEntry;
use Filament\Infolists\Components\TextEntry;


class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;
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
                        TextInput::make('title')->required(),
                        Textarea::make('description'),
                        MarkdownEditor::make('content')->required(),
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
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('description')
                    ->wrap(),
                TextColumn::make('content')
                    ->wrap(),
                ImageColumn::make('image_preview')
                    ->label('Announcement Preview')
                    ->size(110),
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
                EditAction::make()
                    ->label('Update'),
                Action::make('delete')
                    ->label('Delete Announcement')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Announcement $record) => $record->delete()),
                ViewAction::make()
                    ->label('View')
                    ->color('success'),
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
            'index' => Pages\ListAnnouncements::route('/index'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}