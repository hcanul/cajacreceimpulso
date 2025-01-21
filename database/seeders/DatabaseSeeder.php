<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Sucursales\SucursalSeerder;
use Database\Seeders\Users\UsersSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SucursalSeerder::class);
        $this->call(UsersSeeder::class);
    }
}
