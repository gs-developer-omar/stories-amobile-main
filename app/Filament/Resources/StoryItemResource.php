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
    protected static ?string $navigationIcon = 'heroicon-o-photo';
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
                Tables\Columns\TextInputColumn::make('name')
                    ->label('Название элемента сториса')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('file_path')
                    ->url(function($record) {
                        return config('app.url') . '/storage/' . $record->file_path;
                    })
                    ->openUrlInNewTab()
                    ->disk('public')
                    ->square()
                    ->alignCenter()
                    ->width(200)
                    ->height(350)
                    ->label('Медиа'),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->sortable()
                    ->label('Опубликован')
                    ->alignCenter(),
                Tables\Columns\TextInputColumn::make('position')
                    ->label('Позиция')
                    ->alignCenter()
                    ->rules(['required', 'integer', 'min:1'])
                    ->sortable(),
                Tables\Columns\ImageColumn::make('story.icon_url')
                    ->openUrlInNewTab()
                    ->label('Сторис')
                    ->url(function($record) {
                        return config('app.url') . '/admin/stories/' . $record->story->id . '/edit';
                    })
                    ->size(175)
                    ->alignCenter()
                    ->openUrlInNewTab(),
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
