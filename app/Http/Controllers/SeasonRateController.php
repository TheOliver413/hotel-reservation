<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SeasonRateController extends Controller
{
    // Listar todas las tarifas
    public function index()
    {
        try {
            $rates = DB::select('SELECT * FROM season_rates ORDER BY hotel_id, room_type');
            return response()->json($rates);
        } catch (Throwable $e) {
            Log::error('Error al obtener tarifas: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener las tarifas.'], 500);
        }
    }

    // Mostrar tarifa específica
    public function show($id)
    {
        try {
            $rate = DB::select('SELECT * FROM season_rates WHERE id = ?', [$id]);

            if (empty($rate)) {
                return response()->json(['message' => 'Tarifa no encontrada.'], 404);
            }

            return response()->json($rate[0]);
        } catch (Throwable $e) {
            Log::error("Error al obtener tarifa con ID $id: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo obtener la tarifa.'], 500);
        }
    }

    public function getByHotel($hotelId)
    {
        try {
            $rate = DB::select("SELECT * FROM season_rates WHERE hotel_id = ?", [$hotelId]);

            if (empty($rate)) {
                return response()->json(['message' => 'Error al obtener tarifas del hotel.'], 404);
            }

            return response()->json($rate[0]);
        } catch (Throwable $e) {
            Log::error("Error al obtener tarifas del hotel: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo obtener la tarifa.'], 500);
        }
    }

    // Crear una nueva tarifa
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|integer',
            'room_type' => 'required|in:estandar,premium,vip',
            'season' => 'required|in:alta,baja',
            'price_per_person' => 'required|numeric|min:0',
        ]);

        try {
            DB::insert(
                'INSERT INTO season_rates (hotel_id, room_type, season, price_per_person, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())',
                [
                    $request->hotel_id,
                    $request->room_type,
                    $request->season,
                    $request->price_per_person
                ]
            );

            return response()->json(['message' => 'Tarifa creada exitosamente.'], 201);
        } catch (Throwable $e) {
            Log::error('Error al crear tarifa: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo crear la tarifa.'], 500);
        }
    }

    // Actualizar tarifa
    public function update(Request $request, $id)
    {
        $request->validate([
            'hotel_id' => 'required|integer',
            'room_type' => 'required|in:estandar,premium,vip',
            'season' => 'required|in:alta,baja',
            'price_per_person' => 'required|numeric|min:0',
        ]);

        try {
            $updated = DB::update(
                'UPDATE season_rates SET hotel_id = ?, room_type = ?, season = ?, price_per_person = ?, updated_at = NOW() WHERE id = ?',
                [
                    $request->hotel_id,
                    $request->room_type,
                    $request->season,
                    $request->price_per_person,
                    $id
                ]
            );

            if ($updated === 0) {
                return response()->json(['message' => 'Tarifa no encontrada o sin cambios.'], 404);
            }

            return response()->json(['message' => 'Tarifa actualizada correctamente.']);
        } catch (Throwable $e) {
            Log::error("Error al actualizar tarifa con ID $id: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo actualizar la tarifa.'], 500);
        }
    }

    // Eliminar tarifa
    public function destroy($id)
    {
        try {
            $deleted = DB::delete('DELETE FROM season_rates WHERE id = ?', [$id]);

            if ($deleted === 0) {
                return response()->json(['message' => 'Tarifa no encontrada.'], 404);
            }

            return response()->json(['message' => 'Tarifa eliminada correctamente.']);
        } catch (Throwable $e) {
            Log::error("Error al eliminar tarifa con ID $id: " . $e->getMessage());
            return response()->json(['error' => 'No se pudo eliminar la tarifa.'], 500);
        }
    }
}
