<?php

namespace App\Models;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Story extends Model
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
    ];

    public function storyItems(): HasMany
    {
        return $this->hasMany(StoryItem::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleted(function ($story) {
            if ($story->icon_url) {
                // Удаление файла, если он существует
                Storage::disk('public')->delete($story->icon_url);
            }
        });
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('title')
                ->label('Название')
                ->required()
                ->maxLength(60),
            TextInput::make('position')
                ->label('Позиция')
                ->required()
                ->numeric(),
            FileUpload::make('icon_url')
                ->label('Иконка')
                ->directory('stories/icons')
                ->required()
                ->columnSpanFull(),
            Toggle::make('is_published')
                ->label('Опубликован')
                ->required(),
        ];
    }
}
