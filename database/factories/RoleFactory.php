<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roleName = $this->faker->unique()->randomElement(Role::BASIC_ROLES);

        return [
            'name' => $roleName,
            'display_name' => strtoupper(substr($roleName, 0, 1)) . substr($roleName, 1, strlen($roleName) - 1),
            'description' => $this->faker->text(100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
