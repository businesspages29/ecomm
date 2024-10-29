<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            // 'image' => $this->faker->imageUrl(),
            'image' => 'https://placehold.co/100',
            'name' => $this->faker->unique()->word,
            'slug' => $this->faker->unique()->slug,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stocks' => $this->faker->numberBetween(0, 100),
        ];
    }
}
