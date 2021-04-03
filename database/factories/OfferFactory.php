<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\OfferStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
            'name' => $this->faker->text(100),
            'places_number' => $this->faker->numberBetween(1, 15),
            'program' => $this->faker->text,
            'schedule' => $this->faker->text,
            'offer_category_id' => function (array $attributes) {
                return OfferCategory::where('name', $this->faker->randomElement(OfferCategory::BASIC_CATEGORIES))
                    ->get()[0]
                    ->id;
            },
            'offer_status_id' => function (array $attributes) {
                return OfferStatus::where('name', $this->faker->randomElement(OfferStatus::BASIC_STATUSES))
                    ->get()[0]
                    ->id;
            },
            'company_supervisor_id' => User::factory(),
            'interview' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withInterview()
    {
        return $this->state(function (array $attributes) {
            return [
                'interview' => true,
            ];
        });
    }
}
