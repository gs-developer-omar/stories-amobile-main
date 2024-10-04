<?php

use App\Models\AmobileUser;
use App\Models\StoryComment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emoji_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StoryComment::class);
            $table->foreignIdFor(AmobileUser::class, 'phone');
            $table->string('emoji', 10)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->timestamps();

            $table->unique(['story_comment_id', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emoji_reactions');
    }
};
