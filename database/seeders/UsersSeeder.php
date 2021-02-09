<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use config\constants\RoleConstants;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    protected $model = User::class;

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        //1
//        DB::table('users')->insert([
//            'email' => 'admin@example.com',
//            'password_hash' => 'password',
//            'password_reset_token' => 'token',
//            'first_name' => 'Jan',
//            'last_name' => 'Kowalski',
//            'phone_number' => '123123123',
//            'user_status_id' => 1,
//            'created_at' => date('Y-m-d H:i:s'),
//            'updated_at' => date('Y-m-d H:i:s')
//        ]);

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

        User::factory()
            ->state([
                'email' => 'student@example.com'
            ])
            ->hasAttached(
                Role::factory()->state([
                    'name' => Role::ROLE_STUDENT,
                    'display_name' => RoleConstants::ROLE_DISPLAY_NAMES[Role::ROLE_STUDENT],
                    'description' => RoleConstants::ROLE_DESCRIPTIONS[Role::ROLE_STUDENT],
                ]),
                [
                    'user_type' => RoleConstants::ROLE_USER_TYPES[Role::ROLE_STUDENT],
                    'created_at' => now(),
                ]
            )
            ->active()
            ->has(Student::factory())
            ->create();
    }
}
