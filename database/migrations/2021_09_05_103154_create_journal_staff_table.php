<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId("staff_id")->references('id')->on('staff');
            $table->foreignId("visit_id")->references('id')->on('visits');
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
        Schema::dropIfExists('journal_staff');
    }
}
