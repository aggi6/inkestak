<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inkesta>
 */
class PolledFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => $this->faker->word(),
        'email' =>$this->faker->email(),
        'birthDate'=>$this->faker->date(),
        'genre'=>$this->faker->word(),
        'postalCode'=>'asd',
        ];
    }
}
