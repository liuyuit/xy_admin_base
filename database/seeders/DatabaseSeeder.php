<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [];

        if (config('app.env') != 'production') {
            $seeders[] = FirstUserSeeder::class;
            $seeders[] = FakerSeeder::class;
        }

        $this->call($seeders);
    }
}
