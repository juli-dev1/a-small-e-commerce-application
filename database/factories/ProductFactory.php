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
    public function definition()
    {
        return [
            'title' => $this->faker->numerify('Product-####'),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'selling_price' => $this->faker->randomFloat(2, 0, 1000),
            'image' => $this->faker->imageUrl(640,480),
            'description' => $this->faker->text(),
            'category' => $this->faker->name,
            'rating' => $this->faker->numberBetween($min=1, $max=5),
            'quantity' => $this->faker->numberBetween(0, 500),
            'status' => $this->faker->numberBetween($min=0, $max=1),

        ];
    }
}
