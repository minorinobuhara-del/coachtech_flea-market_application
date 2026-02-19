<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'name' => $this->faker->word,
        'description' => $this->faker->sentence,
        'price' => 1000,
        'image_path' => 'test.jpg',
        'condition' => '新品',
        'user_id' => \App\Models\User::factory(),
    ];
    }
}
