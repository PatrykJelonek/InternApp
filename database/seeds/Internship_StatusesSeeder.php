<?php

use Illuminate\Database\Seeder;

class Internship_StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        DB::table('internship_statuses')->insert([
            'name' => 'oczekująca na akceptację',            
            'created_at' => date('Y-m-d H:i:s')            
        ]);

        //2
        DB::table('internship_statuses')->insert([
            'name' => 'oczekująca na ocenę',            
            'created_at' => date('Y-m-d H:i:s')            
        ]);

        //3
        DB::table('internship_statuses')->insert([
            'name' => 'zaliczona',            
            'created_at' => date('Y-m-d H:i:s')            
        ]);

        //4
        DB::table('internship_statuses')->insert([
            'name' => 'niezaliczona',            
            'created_at' => date('Y-m-d H:i:s')            
        ]);

        //5
        DB::table('internship_statuses')->insert([
            'name' => 'w trakcie',            
            'created_at' => date('Y-m-d H:i:s')            
        ]);

        //6
        DB::table('internship_statuses')->insert([
            'name' => 'odrzucona',            
            'created_at' => date('Y-m-d H:i:s')            
        ]);

        //7
        DB::table('internship_statuses')->insert([
            'name' => 'oczekująca na zakończenie',            
            'created_at' => date('Y-m-d H:i:s')            
        ]);
    }
}