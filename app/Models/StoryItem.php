<?php

namespace App\Models;

use App\Enums\api\v1\MediaTypes;
use App\Http\Filters\v1\QueryFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ToggleColumn;
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
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            TextInputColumn::make('name')
                ->label('Название элемента сториса')
                ->searchable(),
            'file_path' => ImageColumn::make('file_path')
                ->getStateUsing(function ($record) {
                    if ($record->media_type === 'link') {
                        return $record->link;
                    }
                    return config('app.url') . '/storage/' . $record->file_path;
                })
                ->url(function($record) {
                    if ($record->media_type === 'link') {
                        return $record->link;
                    }
                    return config('app.url') . '/storage/' . $record->file_path;
                })
                ->openUrlInNewTab()
                ->disk('public')
                ->square()
                ->alignCenter()
                ->width(200)
                ->height(350)
                ->label('Медиа'),
            ToggleColumn::make('is_published')
                ->sortable()
                ->label('Опубликован')
                ->alignCenter(),
            TextInputColumn::make('position')
                ->label('Позиция')
                ->alignCenter()
                ->rules(['required', 'integer', 'min:1'])
                ->sortable(),
            ImageColumn::make('story.icon_url')
                ->openUrlInNewTab()
                ->label('Сторис')
                ->url(function($record) {
                    return config('app.url') . '/admin/stories/' . $record->story->id . '/edit';
                })
                ->size(175)
                ->alignCenter()
                ->openUrlInNewTab()
                ->sortable(),
            TextColumn::make('created_at')
                ->label('Дата создания')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->label('Дата редактирования')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
