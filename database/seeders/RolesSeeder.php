<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	'name' => 'admin',
        	'display_name' => 'Admin',
            'description' =>'Rola superadministratora',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'user',
        	'display_name' => 'User',
            'description' =>'Rola admina',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'student',
        	'display_name' => 'Student',
            'description' =>'Rola studenta - osoba odbywajaca praktyke',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'university-worker',
        	'display_name' => 'Pracownik Uczelni',
            'description' =>'Osoba bezpośrednio nadzorująca praktykanta w zakładzie pracy',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'name' => 'company-worker',
            'display_name' => 'Pracownik Firmy',
            'description' =>'Osoba bezpośrednio nadzorująca praktykanta w zakładzie pracy',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'name' => 'deans-office-worker',
            'display_name' => 'Pracownik Dziekanatu',
            'description' =>'Pracownik dziekanatu',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
