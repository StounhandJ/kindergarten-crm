<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryCostAddChildAndStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_costs', function (Blueprint $table) {
            $table->boolean("is_set_child")->comment("нужно ли указывать ребенка");
            $table->boolean("is_set_staff")->comment("нужно ли указывать сотрудника");
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
            $table->dropColumn("is_set_child");
            $table->dropColumn("is_set_staff");
        });
    }
}
