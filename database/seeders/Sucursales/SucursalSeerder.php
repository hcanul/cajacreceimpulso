<?php

namespace Database\Seeders\Sucursales;

use App\Models\DatabaseConnection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeerder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseConnection::create([
            'office_name' => 'Carrillo',
            'db_name' => 'creceimp_creceimpulso',
            'db_user' => 'creceimp_alcoholico',
            'db_password' => '!nbLm)TLZ4F5',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_user_local' => 'root',
            'db_password_local' => 'root',
        ]);

        DatabaseConnection::create([
            'office_name' => 'Morelos',
            'db_name' => 'creceimp_morelos',
            'db_user' => 'creceimp_morelos',
            'db_password' => 'E=$Ja^sl]svQ',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_user_local' => 'root',
            'db_password_local' => 'root',
        ]);

        DatabaseConnection::create([
            'office_name' => 'Tulum',
            'db_name' => 'creceimp_tulum',
            'db_user' => 'creceimp_tulum',
            'db_password' => '=ghQBbj9t?MM',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_user_local' => 'root',
            'db_password_local' => 'root',
        ]);

        DatabaseConnection::create([
            'office_name' => 'Playa1',
            'db_name' => 'creceimp_playa',
            'db_user' => 'creceimp_playa',
            'db_password' => '~e3KO=BKG697',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_user_local' => 'root',
            'db_password_local' => 'root',
        ]);

        DatabaseConnection::create([
            'office_name' => 'Playa2',
            'db_name' => 'creceimp_playa2',
            'db_user' => 'creceimp_playa2',
            'db_password' => '99PNQQ5=!4[H',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_user_local' => 'root',
            'db_password_local' => 'root',
        ]);

        DatabaseConnection::create([
            'office_name' => 'Cancun1',
            'db_name' => 'creceimp_cancun',
            'db_user' => 'creceimp_cancun',
            'db_password' => 'q*]-roiDZF!*',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_user_local' => 'root',
            'db_password_local' => 'root',
        ]);

        DatabaseConnection::create([
            'office_name' => 'Cancun2',
            'db_name' => 'creceimp_cancun2',
            'db_user' => 'creceimp_cancun',
            'db_password' => 'q*]-roiDZF!*',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_user_local' => 'root',
            'db_password_local' => 'root',
        ]);
    }
}
