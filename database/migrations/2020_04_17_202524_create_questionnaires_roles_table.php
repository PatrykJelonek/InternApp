<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnairesRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questionnaires_roles', function (Blueprint $table) {
            $table->id();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->dateTime('created_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questionnaires_roles');
    }
}
