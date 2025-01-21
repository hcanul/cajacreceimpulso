<?php

namespace App\Livewire\Control\Cajas;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CajaEfectivoController extends Component
{
    use WithPagination;

    public $componentName, $pageTitle, $fecha;

    public function mount()
    {
        $this->componentName = 'SUCURSALES';
        $this->pageTitle = 'TOTALES';
        $this->fecha = null;//date('Y-m-d');
    }

    public function render()
    {
        if($this->fecha)
        {
            $result = $this->fetchPaginatedDataBySpecificDate($this->fecha);
        }else{
            $result = $this->fetchPaginatedDataBySpecificDate(date('Y-m-d'));
        }

        return view('livewire.control.cajas.component',[
            'totales' => $result
        ])
            ->extends('layouts.themes.app')
            ->section('content');
    }

    function fetchPaginatedDataBySpecificDate($specificDate) {
        // Obtener credenciales de las bases de datos
        $databases = DB::table('database_connections')->get();

        $mergedData = collect(); // Usamos una colección para combinar los resultados

        foreach ($databases as $db) {
            // Extraer la parte relevante del nombre de la sucursal
            $branchName = str_replace('creceimp_', '', $db->db_name);

            // Configurar conexión dinámica
            config([
                'database.connections.dynamic' => [
                    'driver'   => 'mysql',
                    'host'     => $db->db_host,
                    'port'     => $db->db_port,
                    'database' => $db->db_name,
                    'username' => env('ACCESS_DB')=='remoto' ? $db->db_user : $db->db_user_local,
                    'password' => env('ACCESS_DB')=='remoto' ? $db->db_password : $db->db_password_local,
                ],
            ]);

            DB::purge('dynamic'); // Limpiar conexiones previas
            DB::reconnect('dynamic'); // Reconectar con credenciales dinámicas

            // Consulta en la base de datos dinámica
            $data = DB::connection('dynamic')
                ->table('charges')
                ->join('credits', 'charges.credit_id', '=', 'credits.id')
                ->join('teams', 'credits.team_id', '=', 'teams.id')
                ->whereDate('charges.created_at', '=', $specificDate)
                ->whereNull('charges.transa')
                ->select(
                    'credits.id as credit_id',
                    DB::raw("CONCAT(teams.name, ' - ', '$branchName') AS team_name"),
                    'charges.pagoTotal',
                    'charges.numPago',
                    'charges.created_at',
                    DB::raw('(CASE WHEN charges.transa IS NULL THEN "Efectivo" ELSE "Banco" END) AS metodo_pago'),
                )
                ->get();

            // Combinar resultados en la colección
            $mergedData = $mergedData->merge($data);
        }

        return [
            'data' => $mergedData->values(), // Datos de la página actual
            'total' => $mergedData->sum('pagoTotal'),    // Total de registros
        ];
    }

    public function Imprimir()
    {
        if($this->fecha)
        {
            $result = $this->fetchPaginatedDataBySpecificDate($this->fecha);
            // dd($result);
            return redirect()->route('generar.corte', [$this->fecha, 'EFECTIVO']);
        }else{
            dd('hugo');
        }
    }

}
