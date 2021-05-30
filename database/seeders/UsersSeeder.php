<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'password_hash' => Hash::make('password'),
            'password_reset_token' => Str::uuid(),
            'first_name' => 'Patryk',
            'last_name' => 'Jelonek',
            'phone' => '000000000',
            'user_status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
