<?php

namespace App\Models;

use App\Http\Filters\v1\QueryFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
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

    public function likes(): HasMany
    {
        return $this->hasMany(StoryLike::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(StoryView::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }

    protected static function boot(): void
    {
        parent::boot();
        static::deleted(function ($story) {
            if ($story->icon_url === 'trash/IconDefault.webp') {
                return;
            }
            if ($story->icon_url) {
                // Удаление файла, если он существует
                Storage::disk('public')->delete($story->icon_url);
            }
        });
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
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
                ->downloadable()
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
