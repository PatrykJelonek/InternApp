<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Company;
use App\Models\CompanyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'city_id' => City::inRandomOrder()->first()->id,
            'street' => $this->faker->streetName,
            'street_number' => $this->faker->randomNumber(2, false),
            'email' => $this->faker->companyEmail,
            'phone' => substr($this->faker->unique()->phoneNumber,0,15),
            'website' => $this->faker->domainName,
            'description' => $this->faker->paragraph,
            'access_code' => $this->faker->unique()->numerify('CODE####'),
            'company_category_id' => CompanyCategory::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
