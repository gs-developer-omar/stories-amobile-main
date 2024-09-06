<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryItemButtonResource\Pages;
use App\Filament\Resources\StoryItemButtonResource\RelationManagers;
use App\Models\StoryItem;
use App\Models\StoryItemButton;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoryItemButtonResource extends Resource
{
    protected static ?string $model = StoryItemButton::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Кнопки на элементах сторисов';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(StoryItemButton::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('button_text')
                    ->url(function($record) {
                        return env('APP_URL') . '/storage/' . $record->media_url;
                    })
                    ->openUrlInNewTab()
                    ->label('Текст кнопки')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->sortable()
                    ->label('Активна')
                    ->boolean(),
                Tables\Columns\TextColumn::make('storyItem.name')
                    ->searchable()
                    ->url(function ($record) {
                        return env('APP_URL') . '/admin/story-items/' . $record->storyItem->id . '/edit';
                    })
                    ->openUrlInNewTab()
                    ->label('Элемент Сториса')
                    ->numeric(),
                Tables\Columns\TextColumn::make('storyItem.story.title')
                    ->searchable()
                    ->url(function ($record) {
                        return env('APP_URL') . '/admin/stories/' . $record->storyItem->story->id . '/edit';
                    })
                    ->openUrlInNewTab()
                    ->label('Сторис')
                    ->numeric(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата редактирования')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListStoryItemButtons::route('/'),
//            'create' => Pages\CreateStoryItemButton::route('/create'),
            'edit' => Pages\EditStoryItemButton::route('/{record}/edit'),
        ];
    }
}
