<?php

namespace Database\Factories;

use App\Models\Agreement;
use App\Models\Company;
use App\Models\Offer;
use App\Models\University;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agreement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'signing_date' => now(),
            'date_from' => Carbon::create(now())->addDays($this->faker->numberBetween(1, 30))->toDateString(),
            'date_to' => Carbon::create(now())->addMonths($this->faker->numberBetween(2, 6))->toDateString(),
            'program' => $this->faker->realText(100),
            'schedule' => $this->faker->realText(100),
            'content' => $this->faker->realText(100),
            'company_id' => Company::inRandomOrder()->first()->id,
            'university_id' => University::inRandomOrder()->first()->id,
            'university_supervisor_id' => '',
            'offer_id' => Offer::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
