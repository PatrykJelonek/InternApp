<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (Role::BASIC_ROLES as $ROLE) {
            DB::table('roles')->insert([
                'name' => $ROLE,
                'display_name' => Role::BASIC_ROLE_DISPLAY_NAMES[$ROLE],
                'description' => Role::BASIC_ROLE_DESCRIPTIONS[$ROLE],
            ]);
        }
    }
}
