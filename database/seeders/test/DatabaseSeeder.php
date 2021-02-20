<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CitiesSeeder::class,
            UserSeeder::class,
            UsersRolesSeeder::class,
            CompaniesSeeder::class,
            UsersCompaniesSeeder::class,
            FacultiesSeeder::class,
            FieldsSeeder::class,
            SpecializationsSeeder::class,
            FacultiesFieldsSeeder::class,
            FieldsSpecializationsSeeder::class,
            UniversitiesSeeder::class,
            UniversitiesFacultiesSeeder::class,
            UsersUniversitiesSeeder::class,
            StudentsSeeder::class,
            OffersSeeder::class,
            AgreementsSeeder::class,
            InternshipsSeeder::class,
            JournalEntriesSeeder::class,
            TasksSeeder::class,
            InternshipsStudentsSeeder::class,
            StudentsTasksSeeder::class,
            StudentsJournalEntriesSeeder::class,
        ]);
    }
}
