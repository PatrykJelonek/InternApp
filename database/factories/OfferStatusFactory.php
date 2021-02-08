<?php

namespace Database\Factories;

use App\Models\OfferStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OfferStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(OfferStatus::BASIC_STATUSES),
            'description' => $this->faker->text(100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
