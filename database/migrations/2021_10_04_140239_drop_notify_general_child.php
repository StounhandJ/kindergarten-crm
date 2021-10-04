<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropNotifyGeneralChild extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_journal_children', function (Blueprint $table) {
            $table->dropColumn("notification");
        });

        //php artisan migrate
        //php artisan migrate:rollback
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_journal_children', function (Blueprint $table) {
            $table->boolean("notification")->default(false)->nullable(true)->change();
        });
    }
}
