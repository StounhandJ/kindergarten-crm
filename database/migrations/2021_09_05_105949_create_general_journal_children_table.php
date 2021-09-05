<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralJournalChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_journal_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId("child_id")->references('id')->on('children');
            $table->boolean("is_paid")->default(false)->comment("Оплачен ли текущий месяц");
            $table->integer("reduction_fees")->default(0)->comment("Уменьшение оплаты");
            $table->integer("increase_fees")->default(0)->comment("Увелечения оплаты");
            $table->string("comment")->default("")->comment("Комментарий");
            $table->boolean("notification")->default(false)->comment("Есть ли уведомление");
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
        Schema::dropIfExists('general_journal_children');
    }
}
