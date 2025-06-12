<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomAvailability;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomAvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();
        $startDate = Carbon::now();
        $days = 10; // Generar disponibilidad para los próximos 10 días

        foreach ($rooms as $room) {
            for ($i = 0; $i < $days; $i++) {
                RoomAvailability::create([
                    'room_id' => $room->id,
                    'date' => $startDate->copy()->addDays($i)->toDateString(),
                    'available_rooms' => rand(0, $room->total_rooms),
                ]);
            }
        }
    }
}
