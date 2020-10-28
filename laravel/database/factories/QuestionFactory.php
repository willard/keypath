<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quiz_id' => 1,
            'category_id' => $this->faker->randomElement([1,2,3]),
            'text' => $this->faker->paragraph(5, true),
            'type' => $this->faker->randomElement(['radio', 'checkbox']),
            'status' => 'published'
        ];
    }
}
