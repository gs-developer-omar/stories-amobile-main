<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryItemButtonResource\Pages;
use App\Filament\Resources\StoryItemButtonResource\RelationManagers;
use App\Models\StoryItemButton;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoryItemButtonResource extends Resource
{
    protected static ?string $model = StoryItemButton::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
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
            ->persistFiltersInSession()
            ->filtersTriggerAction(function($action) {
                return $action->button()->label('Фильтры');
            })
            ->columns([
                Tables\Columns\TextInputColumn::make('button_text')
                    ->rules(['required', 'string', 'min:1','max:255'])
                    ->label('Текст кнопки')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('media_url')
                    ->url(function($record) {
                        return config('app.url') . '/storage/' . $record->media_url;
                    })
                    ->openUrlInNewTab()
                    ->disk('public')
                    ->square()
                    ->alignCenter()
                    ->width(200)
                    ->height(350)
                    ->label('Медиа для кнопки'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable()
                    ->label('Активна')
                    ->alignCenter(),
                Tables\Columns\TextInputColumn::make('position')
                    ->label('Позиция')
                    ->alignCenter()
                    ->rules(['required', 'integer', 'min:1'])
                    ->sortable(),
                Tables\Columns\ImageColumn::make('storyItem.file_path')
                    ->url(function($record) {
                        return config('app.url') . '/admin/story-items/' . $record->storyItem->id . '/edit';
                    })
                    ->openUrlInNewTab()
                    ->disk('public')
                    ->square()
                    ->alignCenter()
                    ->width(200)
                    ->height(350)
                    ->label('Элемент Сториса')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('storyItem.story.icon_url')
                    ->openUrlInNewTab()
                    ->label('Сторис')
                    ->url(function($record) {
                        return config('app.url') . '/admin/stories/' . $record->storyItem->story->id . '/edit';
                    })
                    ->size(175)
                    ->alignCenter()
                    ->openUrlInNewTab()
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
