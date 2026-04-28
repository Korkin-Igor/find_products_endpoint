<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        $is_paid = $this->faker->boolean(); // about 50% products will be free
        return [
            'name' => $this->faker->sentence(rand(1,7)), // some words
            'price' => $is_paid
                ? $this->faker->randomFloat(2, 10, 10_000)
                : 0.0,
            'category_id' => Category::inRandomOrder()->first() ?? Category::factory()->create(),
            'in_stock' => $this->faker->boolean(),
            'rating' => $this->faker->randomFloat(2, 1, 5),
        ];
    }
}
