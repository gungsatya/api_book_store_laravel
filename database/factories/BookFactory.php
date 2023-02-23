<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
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
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph,
            'price' => fake()->biasedNumberBetween(10000, 100000),
            'release_date' => fake()->date,
        ];
    }
}
