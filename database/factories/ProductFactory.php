<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Vendor;
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
            'vendor_id' => Vendor::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->words(2, true),
            'price' => fake()->randomFloat(2, 5, 100),
            'stock' => fake()->numberBetween(5, 100),
            'image_path' =>'https://picsum.photos/640/480?random=' . fake()->randomNumber(),
        ];
    }
}
