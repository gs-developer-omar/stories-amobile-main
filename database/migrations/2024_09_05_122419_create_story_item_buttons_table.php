<?php

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
        Schema::create('story_item_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('button_text', 255);
            $table->text('media_url');
            $table->boolean('is_active')->default(false);
            $table->foreignId('story_item_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_item_buttons');
    }
};
