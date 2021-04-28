<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique();
            $table->string('description', 128)->nullable();
            $table->string('display_name', 128)->nullable();
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
        Schema::dropIfExists('offer_categories');
    }
}
