<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\SeasonRate;
use Illuminate\Database\Seeder;

class SeasonRateSeeder extends Seeder
{
    public function run(): void
    {
        $seasons = ['alta', 'baja'];
        $roomTypes = ['estandar', 'premium', 'vip'];

        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            foreach ($roomTypes as $type) {
                foreach ($seasons as $season) {
                    SeasonRate::create([
                        'hotel_id' => $hotel->id,
                        'room_type' => $type,
                        'season' => $season,
                        'price_per_person' => rand(100000, 300000) / 100, // Ej: $1000.00 - $3000.00
                    ]);
                }
            }
        }
    }
}
