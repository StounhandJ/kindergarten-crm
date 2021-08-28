<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Childrens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('childrens', function (Blueprint $table) {
            $table->string("fio");
            $table->foreignId("group_id")->references('id')->on('groups');
            $table->foreignId("institution_id")->references('id')->on('institutions');
            $table->string("address");
            $table->string("fio_mother");
            $table->string("phone_mother");
            $table->string("fio_father");
            $table->string("phone_father");
            $table->string("comment")->default("");
            $table->integer("rate");
            $table->string("contract")->default("");
            $table->date("date_exclusion")->nullable(true);
            $table->string("reason_exclusion")->default("");
            $table->date("date_birth");
            $table->date("date_enrollment");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('childrens', function (Blueprint $table) {
            $table->dropColumn("fio");
            $table->dropColumn("group_id");
            $table->dropColumn("institution_id");
            $table->dropColumn("address");
            $table->dropColumn("fio_mother");
            $table->dropColumn("phone_mother");
            $table->dropColumn("fio_father");
            $table->dropColumn("phone_father");
            $table->dropColumn("comment");
            $table->dropColumn("rate");
            $table->dropColumn("contract");
            $table->dropColumn("date_exclusion");
            $table->dropColumn("reason_exclusion");
            $table->dropColumn("date_birth");
            $table->dropColumn("date_enrollment");
        });
        Schema::dropIfExists('institution');
    }
}
