<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $hotels = DB::table('hotels')->get()->keyBy('city');
        $roomTypes = DB::table('room_types')->get()->keyBy('name');

        $rooms = [
            ['hotel' => 'Barranquilla', 'type' => 'estandar', 'total' => 30, 'max_people' => 4],
            ['hotel' => 'Barranquilla', 'type' => 'premium', 'total' => 3, 'max_people' => 4],
            ['hotel' => 'Cali', 'type' => 'premium', 'total' => 20, 'max_people' => 6],
            ['hotel' => 'Cali', 'type' => 'vip', 'total' => 2, 'max_people' => 6],
            ['hotel' => 'Cartagena', 'type' => 'estandar', 'total' => 10, 'max_people' => 8],
            ['hotel' => 'Cartagena', 'type' => 'premium', 'total' => 1, 'max_people' => 8],
            ['hotel' => 'Bogotá', 'type' => 'estandar', 'total' => 20, 'max_people' => 6],
            ['hotel' => 'Bogotá', 'type' => 'premium', 'total' => 20, 'max_people' => 6],
            ['hotel' => 'Bogotá', 'type' => 'vip', 'total' => 2, 'max_people' => 6],
        ];

        foreach ($rooms as $r) {
            DB::table('rooms')->insert([
                'hotel_id' => $hotels[$r['hotel']]->id,
                'room_type_id' => $roomTypes[$r['type']]->id,
                'quantity' => $r['total'],
                'max_people' => $r['max_people'],
            ]);
        }
    }
}
