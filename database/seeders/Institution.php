<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Institution extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("institutions")->insert([
            "name"=>"Детский сад"
        ]);

        DB::table("institutions")->insert([
            "name"=>"Продленка"
        ]);

        DB::table("institutions")->insert([
            "name"=>"Лагерь"
        ]);
    }
}
