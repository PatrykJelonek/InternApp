<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'view-university-students',
                'display_name' => 'Wyświetl studentów uniwersytetu',
                'description' => 'Pozwala wyświetlić studentów z danego uniwersytetu',
            ],
            [
                'name' => 'view-student',
                'display_name' => 'Wyświetl studenta',
                'description' => 'Pozwala wyświetlić danego studenta',
            ],
        ]);
    }
}
