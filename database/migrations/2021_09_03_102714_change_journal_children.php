<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeJournalChildren extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_children', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->date("create_date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_children', function (Blueprint $table) {
            $table->timestamps();
            $table->dropColumn("create_date");
        });
    }
}
