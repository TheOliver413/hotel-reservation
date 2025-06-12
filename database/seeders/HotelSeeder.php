<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('hotels')->insert([
            ['name' => 'Hotel Barranquilla', 'city' => 'Barranquilla'],
            ['name' => 'Hotel Cali', 'city' => 'Cali'],
            ['name' => 'Hotel Cartagena', 'city' => 'Cartagena'],
            ['name' => 'Hotel Bogotá', 'city' => 'Bogotá'],
        ]);
    }
}
