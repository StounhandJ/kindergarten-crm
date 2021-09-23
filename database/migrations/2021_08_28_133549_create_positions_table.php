<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string("name");
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->foreignId("position_id")->references('id')->on('positions');
            $table->string("fio");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn("position_id");
            $table->dropColumn("fio");
        });
        Schema::dropIfExists('positions');
    }
}
