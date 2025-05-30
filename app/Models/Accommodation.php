<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accommodation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name'];

    // funcion para la relacion con hotel
    public function hotelRooms()
    {
        return $this->hasMany(HotelRoom::class);
    }
}
