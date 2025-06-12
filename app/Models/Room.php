<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['hotel_id', 'type', 'total_rooms', 'max_people'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function availabilities()
    {
        return $this->hasMany(RoomAvailability::class);
    }
}
