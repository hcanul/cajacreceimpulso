<?php

namespace App\Http\Controllers;

use App\Services\DatabaseConnectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function getOfficeData($officeName)
    {
        try {
            // Cambiar conexión a la base de datos correspondiente
            DatabaseConnectionService::switchToOfficeDatabase($officeName);

            // Obtener datos de la tabla en la base de datos dinámica
            $data = DB::table('your_table')->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al conectar: ' . $e->getMessage()], 500);
        }
    }
}
