<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->softDeletes();
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
            $table->dropSoftDeletes();
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
