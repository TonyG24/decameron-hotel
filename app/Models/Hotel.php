<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'city', 'nit', 'room_limit'];
    
    // declaramos funcion para obtener las habitaciones asociadas
    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }
}
