<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=> fake()->sentence(2),
            'description' => fake()->paragraph,
            'price' => fake()->biasedNumberBetween(10000, 100000),
            'release_date' => fake()->date,
            'image_path' => 'https://via.placeholder.com/300',
        ];
    }
}
