<?php

namespace Database\Factories;

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
            'vendor_id' => $this->faker->numberBetween(1, 10),
            'category_id' => $this->faker->numberBetween(1, 5),
            'name' => fake()->words(2, true),
            'price' => fake()->randomFloat(2, 5, 100),
            'stock' => fake()->numberBetween(5, 100),
            'image_path' =>'https://picsum.photos/' . fake()->uuid . '/640/480',
        ];
    }
}
