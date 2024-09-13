<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryLike extends Model
{
    use HasFactory;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'story_id' => 'integer',
        'amobile_user_id' => 'integer',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function amobileUser(): BelongsTo
    {
        return $this->belongsTo(AmobileUser::class);
    }
}
