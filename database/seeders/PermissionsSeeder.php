<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        foreach (Permission::PERMISSIONS as $PERMISSION) {
            DB::table('permissions')->insert([
                'name' => $PERMISSION,
                'display_name' => Permission::PERMISSIONS_DISPLAY_NAMES[$PERMISSION],
                'description' => Permission::PERMISSIONS_DESCRIPTIONS[$PERMISSION]
            ]);
        }
    }
}
