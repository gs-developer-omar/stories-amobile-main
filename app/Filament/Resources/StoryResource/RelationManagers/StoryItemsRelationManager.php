<?php

namespace App\Filament\Resources\StoryResource\RelationManagers;

use App\Models\StoryItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoryItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'storyItems';
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Элементы Сториса';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(StoryItem::getForm($this->getOwnerRecord()->id));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextInputColumn::make('name')
                    ->rules(['required', 'string', 'min:1', 'max:255'])
                    ->label('Название элемента'),
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
                    ->label('Опубликован'),
                Tables\Columns\TextInputColumn::make('position')
                    ->label('Позиция')
                    ->rules(['required', 'integer', 'min:1'])
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->slideOver(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
