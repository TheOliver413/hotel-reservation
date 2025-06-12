<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    public function index()
    {
        try {
            $rooms = DB::select("SELECT * FROM rooms");
            return response()->json($rooms);
        } catch (\Exception $e) {
            Log::error("Error al obtener las habitaciones: " . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener las habitaciones'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|integer',
            'type' => 'required|string|in:estandar,premium,vip',
            'total_rooms' => 'required|integer|min:1',
            'max_people' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        }

        try {
            DB::insert(
                "INSERT INTO rooms (hotel_id, type, total_rooms, max_people, created_at, updated_at) VALUES (?, ?, ?, ?, now(), now())",
                [
                    $request->hotel_id,
                    $request->type,
                    $request->total_rooms,
                    $request->max_people
                ]
            );
            return response()->json(['message' => 'Habitación creada exitosamente'], 201);
        } catch (\Exception $e) {
            Log::error("Error al crear la habitación: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo crear la habitación'], 500);
        }
    }

    public function show($id)
    {
        try {
            $room = DB::select("SELECT * FROM rooms WHERE hotel_id = ?", [$id]);
            if (!$room) {
                return response()->json(['message' => 'Habitación no encontrada'], 404);
            }
            return response()->json($room[0]);
        } catch (\Exception $e) {
            Log::error("Error al obtener la habitación: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo obtener la habitación'], 500);
        }
    }

    public function getByHotel($hotelId)
    {
        try {
            $room = DB::select("SELECT * FROM rooms WHERE hotel_id = ?", [$hotelId]);
            if (!$room) {
                return response()->json(['message' => 'Habitaciónes no encontrada para el hotel '+$hotelId], 404);
            }
            return response()->json($room[0]);
        } catch (\Exception $e) {
            Log::error("Error al obtener la habitación: " . $e->getMessage());
            return response()->json(['error' => 'Error al obtener habitaciones del hotel'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|string|in:estandar,premium,vip',
            'total_rooms' => 'sometimes|integer|min:1',
            'max_people' => 'sometimes|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        }

        try {
            $room = DB::select("SELECT * FROM rooms WHERE id = ?", [$id]);
            if (!$room) {
                return response()->json(['message' => 'Habitación no encontrada'], 404);
            }

            $fields = [];
            $params = [];

            if ($request->has('type')) {
                $fields[] = "type = ?";
                $params[] = $request->type;
            }
            if ($request->has('total_rooms')) {
                $fields[] = "total_rooms = ?";
                $params[] = $request->total_rooms;
            }
            if ($request->has('max_people')) {
                $fields[] = "max_people = ?";
                $params[] = $request->max_people;
            }

            $params[] = $id;

            $query = "UPDATE rooms SET " . implode(', ', $fields) . ", updated_at = now() WHERE id = ?";
            DB::update($query, $params);

            return response()->json(['message' => 'Habitación actualizada exitosamente']);
        } catch (\Exception $e) {
            Log::error("Error al actualizar la habitación: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo actualizar la habitación'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $room = DB::select("SELECT * FROM rooms WHERE id = ?", [$id]);
            if (!$room) {
                return response()->json(['message' => 'Habitación no encontrada'], status: 404);
            }

            DB::delete("DELETE FROM rooms WHERE id = ?", [$id]);
            return response()->json(['message' => 'Habitación eliminada exitosamente']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar la habitación: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo eliminar la habitación'], 500);
        }
    }
}
