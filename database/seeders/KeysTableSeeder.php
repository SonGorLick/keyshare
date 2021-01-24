<?php

namespace Database\Seeders;

use App\Models\Key;
use Illuminate\Database\Seeder;

class KeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Key::factory()
            ->count(500)
            ->create();

        // Artisan::call('karma:calculate');
    }
}
