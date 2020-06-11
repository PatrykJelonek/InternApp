<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	'name' => 'Superadministrator',
        	'display_name' => 'Superadmin',
            'description' =>'Rola superadministratora',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'Administrator',
        	'display_name' => 'Admin',
            'description' =>'Rola admina',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'Student',
        	'display_name' => 'Student',
            'description' =>'Rola studenta - osoba odbywajaca praktyke',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'Opiekun zakladowy',
        	'display_name' => 'Opiekun zakladowy',
            'description' =>'Osoba bezpośrednio nadzorująca praktykanta w zakładzie pracy',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'Koordynator zakładowy',
        	'display_name' => 'Koordynator zakładowy',
            'description' =>'Osoba zatwierdzająca praktykę w zakładzie pracy',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        	'name' => 'Koordynator uczelniany',
        	'display_name' => 'Koordynator uczelniany',
            'description' =>'Osoba nadzorujaca praktyki z ramienia uczelni',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'name' => 'Dyrektor lub rektor',
            'display_name' => 'Dyrektor lub rektor',
            'description' =>'Dyrektor instytutu  lub rektor wydziału',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'name' => 'Dziekanat',
            'display_name' => 'Dziekanat',
            'description' =>'Dziekanat',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
