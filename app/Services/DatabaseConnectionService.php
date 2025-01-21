<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseConnectionService
{
    // public static function switchToOfficeDatabase($officeName)
    // {
    //     // Obtén las credenciales de la base de datos desde la tabla principal
    //     $connection = DB::table('database_connections')->where('office_name', $officeName)->first();

    //     if (!$connection) {
    //         throw new \Exception("No se encontró configuración para la oficina: {$officeName}");
    //     }

    //     // Configura la nueva conexión
    //     Config::set('database.connections.dynamic', [
    //         'driver' => 'mysql',
    //         'host' => $connection->db_host,
    //         'port' => $connection->db_port,
    //         'database' => $connection->db_name,
    //         'username' => $connection->db_user,
    //         'password' => $connection->db_password,
    //         'charset' => 'utf8mb4',
    //         'collation' => 'utf8mb4_unicode_ci',
    //         'prefix' => '',
    //         'strict' => true,
    //     ]);

    //     // Purga la conexión anterior y conecta con la nueva
    //     DB::purge('dynamic');
    //     DB::reconnect('dynamic');

    //     // Opcional: establece la conexión como predeterminada
    //     DB::setDefaultConnection('dynamic');
    // }
}
