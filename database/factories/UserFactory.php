<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password_hash' => Hash::make("password"),
            'password_reset_token' => Str::random(64),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => substr($this->faker->phoneNumber,0,15),
            'remember_token' => 'remember_token',
            'user_status_id' => $this->faker->numberBetween(1, 2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * @return UserFactory
     */
    public function active(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_status_id' => UserStatus::where('name', UserStatus::STATUS_ACTIVE)->first(),
            ];
        });
    }

    /**
     * @return UserFactory
     */
    public function inactive(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_status_id' => UserStatus::where('name', UserStatus::STATUS_INACTIVE)->first(),
            ];
        });
    }
}
