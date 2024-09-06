<?php

namespace Database\Seeders;

use App\Models\Story;
use App\Models\StoryItem;
use App\Models\StoryItemButton;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Story::factory(10)->create();
        StoryItem::factory(10)->create();
        StoryItemButton::factory(10)->create();

        User::factory()->create([
            'name' => 'Омар',
            'email' => 'gs_zero_main@mail.ru',
            'password' => '1411320Onq',
        ]);
    }
}
