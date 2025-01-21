<?php

namespace App\Livewire\DashBoards;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardController extends Component
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
            $result = $this->fetchTotalsByConnection($this->fecha);
        }else{
            $result = $this->fetchTotalsByConnection(date('Y-m-d'));
        }


        return view('livewire.dash-boards.component',[
            'totales' => $result
        ])
            ->extends('layouts.themes.app')
            ->section('content');
    }

    function fetchTotalsByConnection($specificDate) {
        // Obtener credenciales de las bases de datos
        $databases = DB::table('database_connections')->get();

        $globalTotal = [
            'total_efectivo' => 0,
            'total_bancos' => 0,
            'total_general' => 0,
            'details' => [],
        ];

        foreach ($databases as $db) {
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
            $totals = DB::connection('dynamic')
                ->table('teams')
                ->join('credits', 'teams.id', '=', 'credits.team_id')
                ->join('charges', 'credits.id', '=', 'charges.credit_id')
                ->whereDate('charges.created_at', $specificDate)
                ->selectRaw('
                    SUM(CASE WHEN charges.transa IS NULL THEN charges.pagoTotal ELSE 0 END) AS total_efectivo,
                    SUM(CASE WHEN charges.transa IS NOT NULL THEN charges.pagoTotal ELSE 0 END) AS total_bancos,
                    SUM(charges.pagoTotal) AS total_general
                ')
                ->first();

            // Agregar los totales de la conexión al total global
            $globalTotal['details'][] = [
                'db_name' => $db->db_name,
                'total_efectivo' => $totals->total_efectivo,
                'total_bancos' => $totals->total_bancos,
                'total_general' => $totals->total_general,
            ];

            $globalTotal['total_efectivo'] += $totals->total_efectivo;
            $globalTotal['total_bancos'] += $totals->total_bancos;
            $globalTotal['total_general'] += $totals->total_general;
        }

        return $globalTotal;
    }
}
