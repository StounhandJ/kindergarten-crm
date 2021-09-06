<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixStaffReasonDismissal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string("reason_dismissal")->nullable()->change();
        });

        Schema::table('children', function (Blueprint $table) {
            $table->string("reason_exclusion")->nullable()->change();
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
            $table->string("reason_dismissal")->nullable(false)->change();
        });

        Schema::table('children', function (Blueprint $table) {
            $table->string("reason_exclusion")->nullable()->change();
        });
    }
}
