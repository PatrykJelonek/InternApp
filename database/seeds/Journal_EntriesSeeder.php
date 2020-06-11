<?php

use Illuminate\Database\Seeder;

class Journal_EntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('journal_entries')->insert([
            'internship_id' => 1,
            'content' => 'Wprowadzenie w działalność firmy i zapoznanie się z obowiązkami.',
            'user_id' => 1,
            'accepted' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('journal_entries')->insert([
            'internship_id' => 2,
            'content' => 'Wprowadzenie w działalność firmy i zapoznanie się z obowiązkami.',
            'user_id' => 2,
            'accepted' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('journal_entries')->insert([
            'internship_id' => 3,
            'content' => 'Wprowadzenie w działalność firmy i zapoznanie się z obowiązkami.',
            'user_id' => 3,
            'accepted' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('journal_entries')->insert([
            'internship_id' => 1,
            'content' => 'Przygotowanie środowiska i wykonanie powierzonego zadania.',
            'user_id' => 1,
            'accepted' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('journal_entries')->insert([
            'internship_id' => 2,
            'content' => 'Zaprogramowanie mikrokontrolera.',
            'user_id' => 2,
            'accepted' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('journal_entries')->insert([
            'internship_id' => 3,
            'content' => 'Podłączenie komputera do sieci.',
            'user_id' => 3,
            'accepted' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

    }
}
