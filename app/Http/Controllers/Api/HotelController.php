<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\RoomType;
use App\Models\Accommodation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    // consultamos listado de hoteles y sus caracteristicas
    public function index()
    {
       // return Hotel::with('rooms.roomType', 'rooms.accommodation')->get();

       // parseamos solo los datos que necesitamos asi no frutrajmos la bd con datos demas 
        return Hotel::select('id', 'name', 'address', 'city', 'nit', 'room_limit')
        ->with([
            'rooms' => function ($q) {
                $q->select('id', 'hotel_id', 'room_type_id', 'accommodation_id', 'quantity');
            },
            'rooms.roomType' => function ($q) {
                $q->select('id', 'name');
            },
            'rooms.accommodation' => function ($q) {
                $q->select('id', 'name');
            }
        ])
        ->get();
    }

    // consultamos habitaciones
    public function getRoomType(){
        return RoomType::get();
    }

    // consultamos acomodaciones
    public function getAccommodation(){
        return Accommodation::get();
    }

    // guarddamos registro
    public function store(Request $request)
    {
        
        // validamos ddatos
        $data = $request->validate([
            'name' => 'required|unique:hotels,name',
            'address' => 'required',
            'city' => 'required',
            'nit' => 'required|unique:hotels,nit',
            'room_limit' => 'required|integer|min:1',
            'rooms' => 'required|array',
            'rooms.*.room_type_id' => 'required|exists:room_types,id',
            'rooms.*.accommodation_id' => 'required|exists:accommodations,id',
            'rooms.*.quantity' => 'required|integer|min:1',
        ]);
        
        // validamos si la cantidad de habitaciones supera la cantidad del hotel
        $totalRooms = collect($data['rooms'])->sum('quantity');
        if ($totalRooms > $data['room_limit']) {
            return response()->json(['error' => 'La cantidad total de habitaciones supera el límite del hotel.'], 422);
        }

        // insertamos en la bd y retornamos mensaje
        DB::beginTransaction();
        try {
            $hotel = Hotel::create($data);

            foreach ($data['rooms'] as $room) {
                // Validación de acomodaciones según tipo
                $allowed = match (RoomType::find($room['room_type_id'])->name) {
                    'Estandar' => ['Sencilla', 'Doble'],
                    'Junior'   => ['Triple', 'Cuádruple'],
                    'Suite'    => ['Sencilla', 'Doble', 'Triple'],
                    default    => [],
                };

                $acom = Accommodation::find($room['accommodation_id'])->name;
                if (!in_array($acom, $allowed)) {
                    return response()->json([
                        'error' => "La acomodación '$acom' no es válida para el tipo de habitación ".RoomType::find($room['room_type_id'])->name
                    ], 422);
                }

                HotelRoom::create([
                    'hotel_id' => $hotel->id,
                    'room_type_id' => $room['room_type_id'],
                    'accommodation_id' => $room['accommodation_id'],
                    'quantity' => $room['quantity']
                ]);
            }

            DB::commit();
            return response()->json($hotel->load('rooms.roomType', 'rooms.accommodation'), 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al guardar el hotel'], 500);
        }
    }
}
