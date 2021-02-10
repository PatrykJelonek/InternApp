<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('users')->insert([
            'email' => 'admin@example.com',
            'password_hash' => 'password',
            'password_reset_token' => 'token',
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'phone' => '123123123',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
