<?php

use App\Institution;
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
        Institution::create([
            'name' => 'wildlife conservation',
        ]);
        Institution::create([
            'name' => 'forestry conservations',
        ]);
    }
}
