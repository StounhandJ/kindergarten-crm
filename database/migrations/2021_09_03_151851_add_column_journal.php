<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_children', function (Blueprint $table) {
            $table->foreignId("child_id")->references('id')->on('children');
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
            $table->dropColumn("child_id");
        });
    }
}
