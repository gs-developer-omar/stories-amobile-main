<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryResource\Pages;
use App\Filament\Resources\StoryResource\RelationManagers;
use App\Models\Story;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationLabel = 'Сторисы';
    protected static ?int $navigationSort = 0;
    public static function getNavigationBadge(): ?string
    {
        return Story::count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return Color::Fuchsia;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Story::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
//            ->persistFiltersInSession()
//            ->filtersTriggerAction(function($action) {
//                return $action->button()->label('Фильтры');
//            })
            ->columns([
                Tables\Columns\TextInputColumn::make('title')
                    ->label('Название Сториса')
                    ->alignStart()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('icon_url')
                    ->url(function($record) {
                        return config('app.url') . '/storage/' . $record->icon_url;
                    })
                    ->openUrlInNewTab()
                    ->label('Иконка')
                    ->disk('public')
                    ->alignCenter()
                    ->size(175)
                    ->defaultImageUrl(fn($record) => config('app.url') . '/trash/iconDefault.webp'),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->sortable()
                    ->label('Опубликован')
                    ->alignCenter(),
                Tables\Columns\TextInputColumn::make('position')
                    ->label('Позиция')
                    ->alignCenter()
                    ->rules(['required', 'integer', 'min:1'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Лайки')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->color(Color::Rose)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->withCount('likes')
                            ->orderBy('likes_count', $direction);
                    })
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Просмотры')
                    ->icon('heroicon-o-eye')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->withCount('views')
                            ->orderBy('views_count', $direction);
                    })
                    ->alignCenter()
                    ->badge(),
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
            ->defaultSort('position', 'desc')
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
            RelationManagers\StoryItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStories::route('/'),
//            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }
}
