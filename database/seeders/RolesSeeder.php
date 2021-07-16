<?php

namespace Database\Seeders;

use App\Constants\RoleConstants;
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
        foreach (RoleConstants::BASIC_ROLES as $ROLE) {
            DB::table('roles')->insert([
                'name' => $ROLE,
                'display_name' => RoleConstants::BASIC_ROLE_DISPLAY_NAMES[$ROLE],
                'description' => RoleConstants::BASIC_ROLE_DESCRIPTIONS[$ROLE],
                'group' => RoleConstants::BASIC_ROLE_GROUP[$ROLE],
            ]);
        }
    }
}
