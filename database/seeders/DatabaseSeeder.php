<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserStatusesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(UniversityTypesSeeder::class);
        $this->call(UniversitiesSeeder::class);
        $this->call(SpecializationsSeeder::class);
        $this->call(OfferCategoriesSeeder::class);
        $this->call(OfferStatusesSeeder::class);
        $this->call(FacultiesSeeder::class);//zmiana
        $this->call(FieldsSeeder::class);//zmiana
        $this->call(QuestionnairesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(Questionnaires_RolesSeeder::class);
        $this->call(Permissions_RolesSeeder::class);
        $this->call(Questionnaire_QuestionsSeeder::class);//jedna ankieta - jedno pytanie
        $this->call(Company_CategoriesSeeder::class);
        $this->call(CompaniesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(MessagesSeeder::class);
        $this->call(Users_RolesSeeder::class);
        $this->call(Users_PermissionsSeeder::class);
        $this->call(User_CompaniesSeeder::class);
        $this->call(Questionnaire_Question_AnswersSeeder::class);
        $this->call(Internship_StatusesSeeder::class);
        $this->call(StudentsSeeder::class);
        $this->call(Universities_FacultiesSeeder::class);
        $this->call(Faculties_FieldsSeeder::class);
        $this->call(Fields_SpecializationsSeeder::class);
        $this->call(OffersSeeder::class);
        $this->call(AgreementsSeeder::class);
        $this->call(InternshipsSeeder::class);
        $this->call(TasksSeeder::class);
        $this->call(Journal_EntriesSeeder::class);
        $this->call(Users_UniversitiesSeeder::class);
    }
}
