<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteEmploye extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn("date_exclusion");
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn("date_dismissal");
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
            $table->date("date_exclusion")->nullable(true);
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->string("date_dismissal")->nullable(true);
        });
    }
}
