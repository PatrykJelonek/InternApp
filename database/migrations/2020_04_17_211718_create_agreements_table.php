<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('slug', 80)->unique();
            $table->date('signing_date');
            $table->date('date_from');
            $table->date('date_to');
            $table->longText('program')->nullable();
            $table->longText('schedule')->nullable();
            $table->longText('content')->nullable();
            $table->foreignId('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreignId('university_id');
            $table->foreign('university_id')->references('id')->on('universities');
            $table->foreignId('university_supervisor_id');
            $table->foreign('university_supervisor_id')->references('id')->on('users');
            $table->foreignId('offer_id')->nullable();
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_active')->default(false);
            $table->dateTime('created_at', 0);
            $table->dateTime('updated_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreements');
    }
}
