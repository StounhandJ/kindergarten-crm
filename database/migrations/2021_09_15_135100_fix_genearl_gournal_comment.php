<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixGenearlGournalComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_journal_staff', function (Blueprint $table) {
            $table->string("comment")->nullable(true)->default("")->change();
        });

        Schema::table('general_journal_children', function (Blueprint $table) {
            $table->string("comment")->nullable(true)->default("")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_journal_staff', function (Blueprint $table) {
            $table->string("comment")->nullable(false)->default("")->change();
        });

        Schema::table('general_journal_child', function (Blueprint $table) {
            $table->string("comment")->nullable(false)->default("")->change();
        });
    }
}
