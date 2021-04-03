<?php

namespace Database\Factories;

use App\Models\UniversityType;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UniversityType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text(32),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
