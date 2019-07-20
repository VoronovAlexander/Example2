<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('sections')->count() != 0) {
            return;
        }

        factory('App\Section', 15)
            ->create();
    }
}
