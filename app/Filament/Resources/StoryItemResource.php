<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryItemResource\Pages;
use App\Filament\Resources\StoryItemResource\RelationManagers;
use App\Models\Story;
use App\Models\StoryItem;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoryItemResource extends Resource
{
    protected static ?string $model = StoryItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Элементы сторисов';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(StoryItem::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->url(function($record) {
                        return env('APP_URL') . '/storage/' . $record->file_path;
                    })
                    ->openUrlInNewTab()
                    ->label('Название элемента')
                    ->searchable(),
                Tables\Columns\TextColumn::make('story.title')
                    ->searchable()
                    ->label('Сторис')
                    ->url(function($record) {
                        return env('APP_URL') . '/admin/stories/' . $record->story->id . '/edit';
                    })
                    ->openUrlInNewTab(),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->sortable()
                    ->label('Опубликован')
                    ->alignCenter(),
                Tables\Columns\TextInputColumn::make('position')
                    ->label('Позиция')
                    ->alignCenter()
                    ->rules(['required', 'integer'])
                    ->sortable(),
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
            RelationManagers\StoryItemButtonsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoryItems::route('/'),
            'edit' => Pages\EditStoryItem::route('/{record}/edit'),
        ];
    }
}
