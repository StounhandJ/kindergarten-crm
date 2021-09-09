<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralJournalStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_journal_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId("staff_id")->references('id')->on('staff');
            $table->integer("reduction_salary")->default(0)->comment("Уменьшение зп");
            $table->integer("increase_salary")->default(0)->comment("Увеличение зп");
            $table->integer("advance_payment")->default(0)->comment("Аванс");
            $table->string("comment")->default("")->comment("Комментарий");
            $table->date("month")->comment("Месяц итога");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_journal_staff');
    }
}
