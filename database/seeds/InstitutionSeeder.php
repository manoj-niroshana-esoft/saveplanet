<?php

use App\Institution;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
