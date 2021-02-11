<?php

namespace Database\Seeders;

use Config\Constants\PermissionConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (PermissionConstants::PERMISSIONS as $PERMISSION) {
            DB::table('permissions')->insert([
                'name' => $PERMISSION,
                'display_name' => PermissionConstants::PERMISSIONS_DISPLAY_NAMES[$PERMISSION],
                'description' => PermissionConstants::PERMISSIONS_DESCRIPTIONS[$PERMISSION]
            ]);
        }
    }
}
