<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryCostsIsActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_costs', function (Blueprint $table) {
            $table->boolean("is_active")->default(true)->comment("Используется ли категория");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_costs', function (Blueprint $table) {
            $table->dropColumn("is_active");
        });
    }
}
