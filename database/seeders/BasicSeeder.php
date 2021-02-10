<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use config\constants\RoleConstants;
use Illuminate\Database\Seeder;

class BasicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->state([
                'email' => 'admin@example.com'
            ])
            ->hasAttached(
                Role::factory()->state([
                    'name' => Role::ROLE_ADMIN,
                    'display_name' => RoleConstants::ROLE_DISPLAY_NAMES[Role::ROLE_ADMIN],
                    'description' => RoleConstants::ROLE_DESCRIPTIONS[Role::ROLE_ADMIN],
                ]),
                [
                    'user_type' => RoleConstants::ROLE_USER_TYPES[Role::ROLE_ADMIN],
                    'created_at' => now(),
                ]
            )
            ->active()
            ->create();
    }
}
