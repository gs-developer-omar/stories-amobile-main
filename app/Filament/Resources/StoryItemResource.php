<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryItemResource\Pages;
use App\Filament\Resources\StoryItemResource\RelationManagers;
use App\Models\StoryItem;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

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
//            ->deferFilters()
//            ->filtersApplyAction(
//                fn ($action) => $action
//                    ->label('Применить'),
//            )
            ->persistFiltersInSession()
            ->filtersTriggerAction(function($action) {
                return $action->button()->label('Фильтры');
            })
            ->columns([
                TextInputColumn::make('name')
                    ->label('Название элемента сториса')
                    ->searchable(),
                ImageColumn::make('file_path')
                    ->getStateUsing(function ($record) {
                        if ($record->media_type === 'link' || Str::endsWith($record->file_path, '.mp4')) {
                            return config('app.url') . '/storage/trash/LINK_LOGO_CAT.jpg';
                        }
                        return config('app.url') . '/storage/' . $record->file_path;
                    })
                    ->url(function($record) {
                        if ($record->media_type === 'link') {
                            return $record->link;
                        }
                        return config('app.url') . '/storage/' . $record->file_path;
                    })
                    ->openUrlInNewTab()
                    ->disk('public')
                    ->square()
                    ->alignCenter()
                    ->width(200)
                    ->height(350)
                    ->label('Медиа'),
                ToggleColumn::make('is_published')
                    ->sortable()
                    ->label('Опубликован')
                    ->alignCenter(),
                TextInputColumn::make('position')
                    ->label('Позиция')
                    ->alignCenter()
                    ->rules(['required', 'integer', 'min:1'])
                    ->sortable(),
                ImageColumn::make('story.icon_url')
                    ->openUrlInNewTab()
                    ->label('Сторис')
                    ->url(function($record) {
                        return config('app.url') . '/admin/stories/' . $record->story->id . '/edit';
                    })
                    ->size(175)
                    ->alignCenter()
                    ->openUrlInNewTab()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата редактирования')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_published')
                    ->label('Опубликован')
                    ->query(function($query){
                        return $query->where('is_published', true);
                    }),
                Tables\Filters\SelectFilter::make('story')
                    ->label('Сторис')
                    ->relationship('story', 'title')
                    ->multiple()
                    ->searchable()
                    ->preload(),
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
