<?php

use Illuminate\Database\Seeder;

class Internships_AttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('internships_attachments')->insert([
            'internship_id' => 1,
            'attachment_id' => 2
        ]);

        DB::table('internships_attachments')->insert([
            'internship_id' => 2,
            'attachment_id' => 2
        ]);

        DB::table('internships_attachments')->insert([
            'internship_id' => 3,
            'attachment_id' => 2
        ]);

        DB::table('internships_attachments')->insert([
            'internship_id' => 1,
            'attachment_id' => 3
        ]);

        DB::table('internships_attachments')->insert([
            'internship_id' => 2,
            'attachment_id' => 3
        ]);

        DB::table('internships_attachments')->insert([
            'internship_id' => 3,
            'attachment_id' => 3
        ]);
    }
}
