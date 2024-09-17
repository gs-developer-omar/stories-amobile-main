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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Request;

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
            ->columns(StoryItem::getTableColumns())
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
