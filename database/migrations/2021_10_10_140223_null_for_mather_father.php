<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullForMatherFather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->string("fio_mother")->nullable(true)->change();
            $table->string("phone_mother")->nullable(true)->change();
            $table->string("fio_father")->nullable(true)->change();
            $table->string("phone_father")->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->string("fio_mother")->nullable(false)->change();
            $table->string("phone_mother")->nullable(false)->change();
            $table->string("fio_father")->nullable(false)->change();
            $table->string("phone_father")->nullable(false)->change();
        });
    }
}
