<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique();
            $table->string('display_name', 64);
            $table->string('hex_color', 8)->nullable();
            $table->enum('group', \App\Constants\InternshipStatusConstants::STATUSES);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_statuses');
    }
}
