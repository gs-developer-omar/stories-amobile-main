<?php

namespace App\Models;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class StoryItemButton extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'story_item_id' => 'integer',
    ];

    public function storyItem(): BelongsTo
    {
        return $this->belongsTo(StoryItem::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function ($storyItemButton) {
            if ($storyItemButton->file_path) {
                // Удаление файла, если он существует
                Storage::disk('public')->delete($storyItemButton->media_url);
            }
        });
    }

    public static function getForm($story_item_id = null): array
    {
        return [
            TextInput::make('button_text')
                ->label('Текст кнопки')
                ->required()
                ->maxLength(255),
            Select::make('story_item_id')
                ->hidden(fn() => $story_item_id !== null)
                ->label('Элемент Сториса')
                ->relationship('storyItem', 'name')
                ->required(),
            FileUpload::make('media_url')
                ->label('Медиа')
                ->directory('stories/items/buttons')
                ->required()
                ->columnSpanFull(),
            Toggle::make('is_active')
                ->label('Активна')
                ->required(),
        ];
    }
}
