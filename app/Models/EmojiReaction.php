<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmojiReaction extends Model
{
    use HasFactory;

    public function comment(): BelongsTo
    {
        return $this->belongsTo(StoryComment::class);
    }

    public function amobileUser(): BelongsTo
    {
        return $this->belongsTo(AmobileUser::class);
    }
}
