<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2,7)),
            'user_id' => mt_rand(1,2),
			'slug' => $this->faker->unique()->slug(),
            'body' => $this->faker->paragraph(mt_rand(5,10)),
			'excerpt' => $this->faker->sentence(mt_rand(8,15))
        ];
    }
}
