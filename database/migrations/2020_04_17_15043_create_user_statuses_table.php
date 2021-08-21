<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique();
            $table->string('description', 128)->nullable($value=true);
            $table->string('display_name', 64)->nullable($value=true);
            $table->string('hex_color', 8)->nullable();
            $table->enum('group', \App\Constants\UserStatusConstants::USER_STATUSES)
                ->default(\App\Constants\UserStatusConstants::USER_STATUS_INACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statuses');
    }
}
