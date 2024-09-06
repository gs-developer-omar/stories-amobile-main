<?php

namespace App\Models;

use App\Enums\MediaType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class StoryItem extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'position' => 'integer',
        'is_published' => 'boolean',
        'story_id' => 'integer',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function storyItemButtons(): HasMany
    {
        return $this->hasMany(StoryItemButton::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleting(function ($storyItem) {
            if ($storyItem->file_path) {
                // Удаление файла, если он существует
                Storage::disk('public')->delete($storyItem->file_path);
            }
        });
    }

    public static function getForm($story_id = null): array
    {
        return [
            Group::make()
                ->columnSpanFull()
                ->columns()
                ->schema([
                    TextInput::make('name')
                        ->label('Название элемента')
                        ->default('Шаг 1')
                        ->required(),
                    Select::make('story_id')
                        ->label('Сторис')
                        ->hidden(fn() => $story_id !== null)
                        ->relationship('story', 'title')
                        ->required(),
                ]),
            TextInput::make('position')
                ->label('Позиция')
                ->minValue(1)
                ->columnSpanFull()
                ->required()
                ->numeric(),
            FileUpload::make('file_path')
                ->label('Медиа')
                ->directory('stories/items')
                ->required()
                ->columnSpanFull(),
            Toggle::make('is_published')
                ->label('Опубликован')
                ->required(),
        ];
    }
}
