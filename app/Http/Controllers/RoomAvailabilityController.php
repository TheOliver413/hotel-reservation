<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RoomAvailabilityController extends Controller
{
    // Listar todas las disponibilidades
    public function index()
    {
        try {
            $availabilities = DB::select('SELECT * FROM room_availabilities ORDER BY date ASC');
            return response()->json( $availabilities);
        } catch (Throwable $e) {
            Log::error('Error al obtener disponibilidades: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener las disponibilidades.'], 500);
        }
    }

    // Ver una disponibilidad específica
    public function show($id)
    {
        try {
            $availability = DB::select('SELECT * FROM room_availabilities WHERE id = ?', [$id]);

            if (empty($availability)) {
                return response()->json(['message' => 'Disponibilidad no encontrada.'], 404);
            }

            return response()->json($availability[0]);
        } catch (Throwable $e) {
            Log::error("Error al obtener disponibilidad con ID $id: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo obtener la disponibilidad.'], 500);
        }
    }

    public function getByRoom($roomId)
    {
        try {
            $availability = DB::select("SELECT * FROM room_availability WHERE room_id = ?", [$roomId]);

            if (empty($availability)) {
                return response()->json(['message' => 'Disponibilidad no encontrada.'], 404);
            }

            return response()->json($availability[0]);
        } catch (Throwable $e) {
            Log::error("Error al obtener disponibilidad de la habitación" . $e->getMessage());
            return response()->json(['error' => 'No se pudo obtener la disponibilidad.'], 500);
        }
    }

    // Crear nueva disponibilidad
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'date' => 'required|date',
            'available_rooms' => 'required|integer|min:0',
        ]);

        try {
            DB::insert(
                'INSERT INTO room_availabilities (room_id, date, available_rooms, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())',
                [$request->room_id, $request->date, $request->available_rooms]
            );

            return response()->json(['message' => 'Disponibilidad creada exitosamente.'], 201);
        } catch (Throwable $e) {
            Log::error('Error al crear disponibilidad: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo crear la disponibilidad.'], 500);
        }
    }

    // Actualizar disponibilidad
    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'date' => 'required|date',
            'available_rooms' => 'required|integer|min:0',
        ]);

        try {
            $affected = DB::update(
                'UPDATE room_availabilities SET room_id = ?, date = ?, available_rooms = ?, updated_at = NOW() WHERE id = ?',
                [$request->room_id, $request->date, $request->available_rooms, $id]
            );

            if ($affected === 0) {
                return response()->json(['message' => 'Disponibilidad no encontrada o sin cambios.'], 404);
            }

            return response()->json(['message' => 'Disponibilidad actualizada correctamente.']);
        } catch (Throwable $e) {
            Log::error("Error al actualizar disponibilidad con ID $id: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo actualizar la disponibilidad.'], 500);
        }
    }

    // Eliminar disponibilidad
    public function destroy($id)
    {
        try {
            $deleted = DB::delete('DELETE FROM room_availabilities WHERE id = ?', [$id]);

            if ($deleted === 0) {
                return response()->json(['message' => 'Disponibilidad no encontrada.'], 404);
            }

            return response()->json(['message' => 'Disponibilidad eliminada correctamente.']);
        } catch (Throwable $e) {
            Log::error("Error al eliminar disponibilidad con ID $id: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo eliminar la disponibilidad.'], 500);
        }
    }
}
