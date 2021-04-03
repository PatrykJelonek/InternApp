<?php

namespace Database\Factories;

use App\Models\OfferCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OfferCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(OfferCategory::BASIC_CATEGORIES),
            'description' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
