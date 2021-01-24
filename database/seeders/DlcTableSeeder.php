<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DlcTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('app.dlc_enabled')) {
            Dlc::factory()
                ->count(500)
                ->create();
        }
    }
}
