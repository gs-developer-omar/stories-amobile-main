<?php

namespace App\Filament\Resources\StoryItemResource\RelationManagers;

use App\Models\StoryItemButton;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoryItemButtonsRelationManager extends RelationManager
{
    protected static string $relationship = 'storyItemButtons';
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Кнопки';
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema(StoryItemButton::getForm($this->getOwnerRecord()->id));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('button_text')
            ->columns([
                Tables\Columns\TextInputColumn::make('button_text')
                    ->rules(['required', 'string', 'min:1', 'max:255'])
                    ->label('Текст кнопки'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Активна'),
                Tables\Columns\TextInputColumn::make('position')
                    ->label('Позиция')
                    ->rules(['required', 'integer', 'min:1'])
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
