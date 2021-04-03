<?php

namespace Database\Factories;

use App\Models\Specialization;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'student_index' => $this->faker->randomNumber(5, true),
            'semester' => $this->faker->numberBetween(1, 8),
            'study_year' => $this->faker->numberBetween(1, 4),
            'specialization_id' => Specialization::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
