<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 45)->nullable();
            $table->string('surname', 45)->nullable();
            $table->string('email', 64)->nullable();
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->unsignedBigInteger('ship_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('ranks');
            $table->foreign('ship_id')->references('id')->on('ships');
            Schema::enableForeignKeyConstraints();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crew');
    }
}
