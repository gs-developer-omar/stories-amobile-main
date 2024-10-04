<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmobileUser extends Model
{
    use HasFactory;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'phone' => 'string'
    ];

    public function emojis(): HasMany
    {
        return $this->hasMany(EmojiReaction::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(StoryComment::class);
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

    public static function authenticateAmobileUser(string $phone)
    {
        return self::firstOrCreate([
            'phone' => $phone
        ]);
    }
}
