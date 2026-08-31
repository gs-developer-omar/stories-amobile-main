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
        Schema::table('story_item_buttons', function (Blueprint $table) {
            $table->addColumn('integer', 'pt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('story_item_buttons', function (Blueprint $table) {
            $table->dropColumn('pt_id');
        });
    }
};
