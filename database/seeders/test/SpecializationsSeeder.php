<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specializations')->insert(
            [
                [
                    'name' => 'Projektowanie Baz Danych i Oprogramowania Użytkowego',
                    'description' => 'Projektowanie Baz Danych i Oprogramowania Użytkowego',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Ekonomika Menedżerska',
                    'description' => 'Ekonomika Menedżerska',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Administracja Systemów i Sieci Komputerowych',
                    'description' => 'Administracja Systemów i Sieci Komputerowych',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Grafika Komputerowa i Multimedia',
                    'description' => 'Grafika Komputerowa i Multimedia',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Przedsiębiorczość Gospodarcza',
                    'description' => 'Przedsiębiorczość Gospodarcza',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
//
//        DB::table('specializations')->insert([
//            'name' => 'Grafika Komputerowa',
//            'description' => 'Grafika Komputerowa',
//            'created_at' => date('Y-m-d H:i:s'),
//            'updated_at' => date('Y-m-d H:i:s')
//        ]);
//
//        DB::table('specializations')->insert([
//            'name' => 'Informatyka i ekonometria',
//            'description' => 'Informatyka i ekonometria',
//            'created_at' => date('Y-m-d H:i:s'),
//            'updated_at' => date('Y-m-d H:i:s')
//        ]);
    }
}
