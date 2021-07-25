<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 64)->unique();
            $table->string('password_hash', 255);
            $table->string('password_reset_token', 255)->unique();
            $table->string('activation_token', 255)->unique();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('phone', 16);
            $table->string('avatar_url', 255)->nullable();
            $table->rememberToken();
            $table->foreignId('user_status_id');
            $table->foreign('user_status_id')->references('id')->on('user_statuses');
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
        Schema::dropIfExists('users');
    }
}
