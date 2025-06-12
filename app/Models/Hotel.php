<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function seasonRates()
    {
        return $this->hasMany(SeasonRate::class);
    }
}
