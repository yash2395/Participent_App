<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // States Data
        $states = [
            ['name' => 'Gujarat'],
            ['name' => 'Maharashtra'],
            ['name' => 'Rajasthan'],
        ];

        DB::table('states')->insert($states);

        // Cities Data
        $cities = [
            // Gujarat Cities
            ['state_id' => 1, 'name' => 'Ahmedabad'],
            ['state_id' => 1, 'name' => 'Surat'],
            ['state_id' => 1, 'name' => 'Vadodara'],

            // Maharashtra Cities
            ['state_id' => 2, 'name' => 'Mumbai'],
            ['state_id' => 2, 'name' => 'Pune'],
            ['state_id' => 2, 'name' => 'Nagpur'],

            // Rajasthan Cities
            ['state_id' => 3, 'name' => 'Jaipur'],
            ['state_id' => 3, 'name' => 'Udaipur'],
            ['state_id' => 3, 'name' => 'Jodhpur'],
        ];

        DB::table('cities')->insert($cities);
    }
}
