<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Role;
use App\Models\University;
use App\Models\UniversityType;
use App\Models\User;
use config\constants\RoleConstants;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        University::factory()
            ->state([
                'name' => 'Państwowa Wyższa Szkoła Zawodowa w Elblągu',
                'university_type_id' => UniversityType::factory()->state([
                    'name' => 'Państwowa Wyższa Szkoła Zawodowa'
                ]),
                'city_id' => City::factory()->state([
                    'name' => 'Elbląg',
                    'post_code' => '82-300',
                ]),
                'street' => 'Wojska Polskiego',
                'street_number' => '1',
                'email' => 'pwsz@example.com',
                'phone' => '123-123-123',
                'website' => 'http://pwsz.elblag.pl/',
            ])
            ->hasAttached(
                User::factory()
                    ->hasAttached(Role::where('name', RoleConstants::ROLE_COMPANY_OWNER)->first()),
                [
                    'created_at' => now(),
                ]
            )
            ->hasAttached(
                User::factory()
                    ->count(3)
                    ->hasAttached(
                        Role::where('name', RoleConstants::ROLE_STUDENT),
                        [
                            'user_type' => RoleConstants::ROLE_USER_TYPES[Role::ROLE_ADMIN],
                            'created_at' => now(),
                        ])
            )
            ->create();
    }
}
