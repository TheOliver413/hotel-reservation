<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('room_types')->insert([
            ['name' => 'estandar'],
            ['name' => 'premium'],
            ['name' => 'vip'],
        ]);
    }
}
