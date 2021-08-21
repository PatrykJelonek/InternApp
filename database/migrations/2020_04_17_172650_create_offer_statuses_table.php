<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 16)->unique();
            $table->string('description', 128)->nullable();
            $table->string('display_name', 128);
            $table->string('hex_color', 8)->nullable();
            $table->enum('group',['new','accepted','rejected'])->nullable();
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
        Schema::dropIfExists('offer_statuses');
    }
}
