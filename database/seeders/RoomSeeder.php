<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $roomData = [
            'Hotel Barranquilla' => [
                ['type' => 'estandar', 'total_rooms' => 30, 'max_people' => 4],
                ['type' => 'premium',  'total_rooms' => 3,  'max_people' => 4],
            ],
            'Hotel Cali' => [
                ['type' => 'premium', 'total_rooms' => 20, 'max_people' => 6],
                ['type' => 'vip',     'total_rooms' => 2,  'max_people' => 6],
            ],
            'Hotel Cartagena' => [
                ['type' => 'estandar', 'total_rooms' => 10, 'max_people' => 8],
                ['type' => 'premium',  'total_rooms' => 1,  'max_people' => 8],
            ],
            'Hotel Bogotá' => [
                ['type' => 'estandar', 'total_rooms' => 20, 'max_people' => 6],
                ['type' => 'premium',  'total_rooms' => 20, 'max_people' => 6],
                ['type' => 'vip',      'total_rooms' => 2,  'max_people' => 6],
            ],
        ];

        foreach ($roomData as $hotelName => $rooms) {
            $hotel = Hotel::where('name', $hotelName)->first();

            foreach ($rooms as $room) {
                $hotel->rooms()->create($room);
            }
        }
    }
}
