<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgreementStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'agreement_statuses',
            function (Blueprint $table) {
                $table->id();
                $table->string('name', 16)->unique();
                $table->string('description', 64)->nullable();
                $table->string('display_name', 128);
                $table->string('hex_color', 7)->nullable();
                $table->enum('group', \App\Constants\AgreementStatusConstants::STATUSES);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_statuses');
    }
}
