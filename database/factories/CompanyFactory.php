<?php

namespace Database\Factories;

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
        $companyName = $this->faker->company;

        return [
            'name' => $companyName,
            'city_id' => function (array $attributes) {
                return CompanyCategory::get()[0]->id;
            },
            'street' => $this->faker->streetName,
            'street_number' => $this->faker->randomNumber(2, false),
            'email' => $this->faker->companyEmail,
            'phone' => substr($this->faker->unique()->phoneNumber,0,15),
            'website' => 'safecontact@'.$companyName.'.'.$this->faker->tld,
            'description' => $this->faker->paragraph,
            'access_code' => $this->faker->unique()->numerify('CODE####'),
            'company_category_id' => function (array $attributes) {
                return CompanyCategory::where('name', $this->faker->randomElement(CompanyCategory::BASIC_CATEGORIES))->get()[0]->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
