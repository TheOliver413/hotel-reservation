<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonRate extends Model
{
    use HasFactory;

    protected $fillable = ['hotel_id', 'room_type', 'season', 'price_per_person'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
