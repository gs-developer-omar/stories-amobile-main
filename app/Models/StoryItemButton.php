<?php

namespace App\Models;

use App\Http\Filters\v1\QueryFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
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
        'position' => 'integer'
    ];

    public function storyItem(): BelongsTo
    {
        return $this->belongsTo(StoryItem::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function ($storyItemButton) {
            if ($storyItemButton->media_url === 'trash/IconDefault.webp') {
                return;
            }
            if ($storyItemButton->media_url) {
                // Удаление файла, если он существует
                Storage::disk('public')->delete($storyItemButton->media_url);
            }
        });
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public static function getForm($story_item_id = null): array
    {
        return [
            TextInput::make('button_text')
                ->label('Текст кнопки')
                ->required()
                ->maxLength(255),
            TextInput::make('position')
                ->label('Позиция')
                ->required()
                ->numeric(),
            Select::make('story_item_id')
                ->hidden(fn() => $story_item_id !== null)
                ->label('Элемент Сториса')
                ->columnSpanFull()
                ->relationship('storyItem', 'name')
                ->required(),
            FileUpload::make('media_url')
                ->downloadable()
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
