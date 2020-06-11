<?php

use Illuminate\Database\Seeder;

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
        	'name' => 'Uprawnienia superadministratora',
        	'display_name' => 'Uprawnienia superadministratora',
            'description' => 'Pełen dostęp do bazy i możliwość dodawania,edycji i usuwania zwykłych adminów',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('permissions')->insert([
        	'name' => 'Uprawnienia administratora',
        	'display_name' => 'Uprawnienia administratora',
            'description' => 'Pełen dostęp do bazy bez możliwości dodawania,edycji i usuwania zwykłych adminów',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('permissions')->insert([
        	'name' => 'Uprawnienia studenta',
        	'display_name' => 'Uprawnienia studenta',
            'description' => 'Możliwość wykonywania działań przewidzianych dla studenta',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('permissions')->insert([
        	'name' => 'Uprawnienia zakładu pracy',
        	'display_name' => 'Uprawnienia zakładu pracy',
            'description' => 'Możliwość wykonywania działań przewidzianych dla zakładu pracy',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('permissions')->insert([
        	'name' => 'Uprawnienia uczelni',
        	'display_name' => 'Uprawnienia zakładu pracy',
            'description' => 'Możliwość wykonywania działań przewidzianych dla uczelni',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('permissions')->insert([
        	'name' => 'Uprawnienia ograniczone',
        	'display_name' => 'Uprawnienia ograniczone',
            'description' => 'Możliwość wykonywania tylko wybranych działań',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
