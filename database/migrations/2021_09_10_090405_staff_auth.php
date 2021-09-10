<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StaffAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->foreignId("user_id")->references('id')->on('users');
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->string("e_name");
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string("login");
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
            $table->dropColumn("user_id");
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn("e_name");
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("login");
        });
    }
}
