<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Http\Classes\QuestionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\galdera>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition():array{
        return [
            'question'=>$this->faker->sentence(5),
            'poll_id'=> Poll::factory(),
            'type' => $this->faker->randomElement([QuestionType::OPEN, QuestionType::CLOSE]),
        ];
    }
}
