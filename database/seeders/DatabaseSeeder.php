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
        $this->call([
            UserStatusesSeeder::class,
            UniversityTypesSeeder::class,
            OfferCategoriesSeeder::class,
            OfferStatusesSeeder::class,
            RolesSeeder::class,
            PermissionsSeeder::class,
            CompanyCategoriesSeeder::class,
            UsersSeeder::class,
            UsersRolesSeeder::class,
            InternshipStatusesSeeder::class,
        ]);
    }
}
