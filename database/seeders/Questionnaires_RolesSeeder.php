<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Questionnaires_RolesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        DB::table('questionnaires_roles')->insert([
        	'role_id' => 1,
        	'questionnaire_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('questionnaires_roles')->insert([
        	'role_id' => 2,
        	'questionnaire_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('questionnaires_roles')->insert([
        	'role_id' => 3,
        	'questionnaire_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('questionnaires_roles')->insert([
        	'role_id' => 4,
        	'questionnaire_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('questionnaires_roles')->insert([
        	'role_id' => 1,
        	'questionnaire_id' => 5,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('questionnaires_roles')->insert([
        	'role_id' => 2,
        	'questionnaire_id' => 5,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('questionnaires_roles')->insert([
        	'role_id' => 3,
        	'questionnaire_id' => 5,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('questionnaires_roles')->insert([
        	'role_id' => 4,
        	'questionnaire_id' => 5,
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }
}
