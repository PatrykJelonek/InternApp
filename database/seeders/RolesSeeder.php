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
        DB::table('roles')->insert([
        	'name' => Role::ROLE_ADMIN,
        	'display_name' => 'Admin',
            'description' =>'Rola superadministratora',
        ]);

        DB::table('roles')->insert([
        	'name' => Role::ROLE_USER,
        	'display_name' => 'User',
            'description' =>'Rola admina',
        ]);

        DB::table('roles')->insert([
        	'name' => Role::ROLE_STUDENT,
        	'display_name' => 'Student',
            'description' =>'Rola studenta - osoba odbywajaca praktyke',
        ]);

        DB::table('roles')->insert([
        	'name' => Role::ROLE_UNIVERSITY_WORKER,
        	'display_name' => 'Pracownik Uczelni',
            'description' =>'Osoba bezpośrednio nadzorująca praktykanta w zakładzie pracy',
        ]);

        DB::table('roles')->insert([
        	'name' => Role::ROLE_UNIVERSITY_OWNER,
        	'display_name' => 'Właściciel Uczelni',
            'description' =>'Osoba zarządzająca uczelnią',
        ]);

        DB::table('roles')->insert([
        	'name' => Role::ROLE_DEANERY_WORKER,
        	'display_name' => 'Pracownik dziekanatu',
            'description' =>'Osoba pracująca w dziekanacie',
        ]);

        DB::table('roles')->insert([
            'name' => Role::ROLE_COMPANY_WORKER,
            'display_name' => 'Pracownik Firmy',
            'description' =>'Osoba bezpośrednio nadzorująca praktykanta w zakładzie pracy',
        ]);

        DB::table('roles')->insert([
            'name' => Role::ROLE_COMPANY_OWNER,
            'display_name' => 'Właściciel Firmy',
            'description' =>'Osoba zarządzająca firmą',
        ]);
    }
}
