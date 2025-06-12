<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class HotelController extends Controller
{
    public function index()
    {
        try {
            $hotels = DB::select('SELECT * FROM hotels');
            return response()->json($hotels);
        } catch (Exception $e) {
            Log::error('Error al buscar hoteles: ' . $e->getMessage());
            return response()->json(['error' => 'Error al recuperar hoteles.'], status: 500);
        }
    }

    public function show($id)
    {
        try {
            $hotel = DB::selectOne('SELECT * FROM hotels WHERE id = ?', [$id]);
            if (!$hotel) {
                return response()->json(['error' => 'Hotel no encontrado.'], 404);
            }
            return response()->json($hotel);
        } catch (Exception $e) {
            Log::error('Error al obtener el hotel: ' . $e->getMessage());
            return response()->json(['error' => 'Error al recuperar el hotel.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'city' => 'required|string|max:255',
            ]);

            DB::insert('INSERT INTO hotels (name, city, created_at, updated_at) VALUES (?, ?, now(), now())', [
                $validated['name'],
                $validated['city'],
            ]);

            return response()->json(['message' => 'Hotel creado con éxito.'], 201);
        } catch (Exception $e) {
            Log::error('Error al crear hotel: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear el hotel.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'city' => 'sometimes|string|max:255',
            ]);

            $fields = [];
            $values = [];
            foreach ($validated as $key => $value) {
                $fields[] = "$key = ?";
                $values[] = $value;
            }

            if (empty($fields)) {
                return response()->json(['error' => 'No hay campos para actualizar.'], 400);
            }

            $values[] = $id;
            $sql = 'UPDATE hotels SET ' . implode(', ', $fields) . ', updated_at = now() WHERE id = ?';

            $affected = DB::update($sql, $values);

            if ($affected === 0) {
                return response()->json(['error' => 'Hotel no encontrado o no se realizaron cambios.'], 404);
            }

            return response()->json(['message' => 'Hotel actualizado con éxito.']);
        } catch (Exception $e) {
            Log::error('Error al actualizar el hotel: ' . $e->getMessage());
            return response()->json(['error' => 'Error al actualizar el hotel.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::delete('DELETE FROM hotels WHERE id = ?', [$id]);
            if ($deleted === 0) {
                return response()->json(['error' => 'Hotel no encontrado.'], 404);
            }
            return response()->json(['message' => 'Hotel eliminado correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al eliminar el hotel: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar el hotel:'], 500);
        }
    }
}
