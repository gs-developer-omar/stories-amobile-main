<?php

namespace App\Models;

use App\Http\Filters\v1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoryComment extends Model
{
    use HasFactory;

    public static array $relationships = [
        'replies',
        'emojis'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'content' => 'string',
    ];

    public function emojis(): HasMany
    {
        return $this->hasMany(EmojiReaction::class);
    }

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
    protected function notRecursiveReplies(): HasMany
    {
        return $this->hasMany(StoryComment::class, 'parent_id');
    }
    public function replies(): HasMany
    {
        return $this->notRecursiveReplies()->with('replies');
    }
    public function amobileUser(): BelongsTo
    {
        return $this->belongsTo(AmobileUser::class);
    }
    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
