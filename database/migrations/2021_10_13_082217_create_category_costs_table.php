<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_costs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("is_profit");
        });

        Schema::table('costs', function (Blueprint $table) {
            $table->foreignId("category_id")->references('id')->on('category_costs');
            $table->dropColumn("is_profit");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->dropColumn("category_id");
            $table->boolean("is_profit");
        });

        Schema::dropIfExists('category_costs');
    }
}
