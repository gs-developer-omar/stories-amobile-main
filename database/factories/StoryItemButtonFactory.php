<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\StoryItem;
use App\Models\StoryItemButton;

class StoryItemButtonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoryItemButton::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'button_text' => $this->faker->sentence(4),
            'media_url' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(),
            'story_item_id' => StoryItem::factory(),
        ];
    }
}
