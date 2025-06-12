<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            ['name' => 'Hotel Barranquilla', 'city' => 'Barranquilla'],
            ['name' => 'Hotel Cali',         'city' => 'Cali'],
            ['name' => 'Hotel Cartagena',    'city' => 'Cartagena'],
            ['name' => 'Hotel Bogotá',       'city' => 'Bogotá'],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
