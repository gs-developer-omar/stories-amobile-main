<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Story;
use App\Models\StoryItem;

class StoryItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoryItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'file_path' => $this->faker->imageUrl(),
            'position' => $this->faker->randomNumber(),
            'is_published' => $this->faker->boolean(),
            'story_id' => Story::factory(),
        ];
    }
}
