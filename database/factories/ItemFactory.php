<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'category_id' => $this->faker->numberBetween(13, 16),
            'image' => $this->faker->imageUrl(640, 480, 'food'),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
