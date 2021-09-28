<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColumnUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('general_journal_children', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('general_journal_staff', function (Blueprint $table) {
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
         Schema::table('groups', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('general_journal_children', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('general_journal_staff', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
