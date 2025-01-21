<?php

namespace App\Http\Controllers\CorteCaja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;

class CorteCajaController extends Controller
{
    function corte($fecha, $tipo = "EFECTIVO")
    {

        $pdf = new PDF('P', 'mm', 'LETTER');
        $result = $this->fetchPaginatedDataBySpecificDate($fecha, $tipo);
        $pdf->variables($fecha, $result['total'], $tipo);
        $data = $result['data'];
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFillColor(199, 199, 199);
        $pdf->SetTextColor(64);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('Arial', 'B', 8);

        $titles = array('NÚM', 'ID.AUTO', 'NOMBRE GRUPO', 'PAGO TOTAL', 'NÚM.PAGO', 'FECHA Y HORA PAGO');
        $th = 5;
        $col_width = $pdf->GetPageWidth()/7;

        foreach ($titles as $value) {
            if($value == 'NÚM'){
                $pdf->Cell($col_width - 20, $th, $value, 1, 0, 'C', 1);
            } else if ($value == 'ID.AUTO'){
                $pdf->Cell($col_width - 10, $th, $value, 1, 0, 'C', 1);
            }else if ($value == 'NOMBRE GRUPO'){
                $pdf->Cell($col_width + 35, $th, $value, 1, 0, 'C', 1);
            }else if ($value == 'FECHA Y HORA PAGO'){
                $pdf->Cell($col_width + 10, $th, $value, 1, 0, 'C', 1);
            }else{
                $pdf->Cell($col_width, $th, $value, 1, 0, 'C', 1);
            }
        }
        $pdf->Ln();
        $i = 1;
        $pdf->SetFont('Arial', '', 7);
        foreach ($data as $key => $value) {
            $fill = $i%2 ? 0 : 1;
            $pdf->Cell($col_width - 20, $th, $i, 1, 0, 'C', $fill);
            $pdf->Cell($col_width - 10, $th, $value->credit_id, 1, 0, 'C', $fill);
            $pdf->Cell($col_width + 35, $th, $value->team_name, 1, 0, 'C', $fill);
            $pdf->Cell($col_width, $th, "$ " . number_format($value->pagoTotal, 2), 1, 0, 'C', $fill);
            $pdf->Cell($col_width, $th, $value->numPago, 1, 0, 'C', $fill);
            $pdf->Cell($col_width + 10, $th, $value->created_at, 1, 0, 'C', $fill);
            $pdf->Ln();
            $i += 1;
        }


        $pdf->Output('I','EstadoCuenta');
    }

    function fetchPaginatedDataBySpecificDate($specificDate, $tipo) {
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

            if($tipo == 'EFECTIVO')
            {
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
            }else{
                // Consulta en la base de datos dinámica
                $data = DB::connection('dynamic')
                ->table('charges')
                ->join('credits', 'charges.credit_id', '=', 'credits.id')
                ->join('teams', 'credits.team_id', '=', 'teams.id')
                ->whereDate('charges.created_at', '=', $specificDate)
                ->whereNotNull('charges.transa')
                ->select(
                    'credits.id as credit_id',
                    DB::raw("CONCAT(teams.name, ' - ', '$branchName') AS team_name"),
                    'charges.pagoTotal',
                    'charges.numPago',
                    'charges.created_at',
                    DB::raw('(CASE WHEN charges.transa IS NULL THEN "Efectivo" ELSE "Banco" END) AS metodo_pago'),
                )
                ->get();
            }

            // Combinar resultados en la colección
            $mergedData = $mergedData->merge($data);
        }

        return [
            'data' => $mergedData->values(), // Datos de la página actual
            'total' => $mergedData->sum('pagoTotal'),    // Total de registros
        ];
    }

}

class PDF extends FPDF
{
    public $fecha;
    public $total;
    public $tipo;

    function variables($fecha, $total, $tipo) {
        $this->fecha = $fecha;
        $this->total = $total;
        $this->tipo = $tipo;

    }

    function header()
    {
        $imagenes = public_path().'/static/img/';

        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial', 'B', 12);

        $this->Image($imagenes.'/logo.png', 10, 10, 50);

        $this->Cell(0, 10, 'CRECEIMPULSO', 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 9);

        $this->SetFillColor(184, 188, 191);
        $this->Cell(0, 5, "CORTE DE CAJA AL DÍA  ". $this->fecha, 0, 0, 'C' );

        $this->Ln();
        $this->SetFont('Arial', 'B', 9);

        $this->SetFillColor(184, 188, 191);
        $this->Cell(0, 5, $this->tipo, 0, 0, 'C' );

        $this->SetFont('Arial', 'B', 12);
        $this->Ln(15);
        $this->Cell(120, 5, '', 0, 0, 'C' );
        $this->Cell(20, 12, "TOTAL: ", 0, 0, 'R',);
        $this->Cell(55, 12, "$ " . number_format($this->total, 2), 1, 0, 'R', 1);
        $this->Ln(15);

    }
}
