<?php

namespace App\Models;

use App\Http\Filters\v1\QueryFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Builder;
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
        'media_type' => 'string',
        'question' => 'string'
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
            if ($storyItem->file_path === 'trash/IconDefault.webp') {
                return;
            }
            if ($storyItem->file_path) {
                // Удаление файла, если он существует
                Storage::disk('public')->delete($storyItem->file_path);
            }
        });
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public static function getForm($story_id = null): array
    {
        return [
            Tabs::make('tabs')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Обязательные поля')
                        ->schema([
                            Group::make()
                                ->columnSpanFull()
                                ->columns()
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Название элемента')
                                        ->required(),
                                    TextInput::make('position')
                                        ->label('Позиция')
                                        ->minValue(1)
                                        ->required()
                                        ->numeric(),
                                ]),
                            Select::make('story_id')
                                ->label('Сторис')
                                ->columnSpanFull()
                                ->hidden(fn() => $story_id !== null)
                                ->relationship('story', 'title')
                                ->required(),
                            Select::make('media_type')
                                ->label('Тип медиа')
                                ->default('media_file')
                                ->options([
                                    'media_file' => 'Файл',
                                    'link' => 'Ссылка'
                                ])
                                ->selectablePlaceholder(false)
                                ->required()
                                ->live(),
                            TextInput::make('link')
                                ->label('Ссылка')
                                ->visible(function(?Model $record, Get $get) {
                                    $media_type = $get('media_type');
                                    $record_media_type = $record->$media_type ?? '';
                                    return $media_type === 'link' || $record_media_type === 'link';
                                })
                                ->required(function(?Model $record, Get $get) {
                                    $media_type = $get('media_type');
                                    $record_media_type = $record->$media_type ?? '';
                                    return $media_type === 'link' || $record_media_type === 'link';
                                }),
                            FileUpload::make('file_path')
                                ->downloadable()
                                ->label('Медиа')
                                ->directory('stories/items')
                                ->maxSize(40960)
                                ->visible(function(?Model $record, Get $get) {
                                    $media_type = $get('media_type');
                                    $record_media_type = $record->$media_type ?? '';
                                    return $media_type === 'media_file' || $record_media_type === 'media_file';
                                })
                                ->required(function(?Model $record, Get $get) {
                                    $media_type = $get('media_type');
                                    $record_media_type = $record->$media_type ?? '';
                                    return $media_type === 'media_file' || $record_media_type === 'media_file';
                                })
                                ->columnSpanFull(),
                            Toggle::make('is_published')
                                ->label('Опубликован')
                                ->required(),
                        ]),
                    Tab::make('Вопрос')
                        ->schema([
                            TextInput::make('question')
                                ->label('Вопрос')
                                ->suffixIcon('heroicon-o-question-mark-circle')
                                ->suffixIconColor(Color::Yellow)
                                ->helperText('Вопрос является необязательным полем. Он нужен если вы хотите добавить квиз на элемент сториса. После того как заполните это поле, вам будет необходимо добавить кнопки для этого элемента сториса, которые будут являться возможными вариантами ответов на этот вопрос.')
                        ]),
                ]),
        ];
    }
}
