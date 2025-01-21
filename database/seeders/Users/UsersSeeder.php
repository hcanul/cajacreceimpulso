<?php

namespace Database\Seeders\Users;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Hugo Paulino Canul Echazarrete',
            'email' => 'cyber.frenetic@gmail.com',
            'password' => bcrypt('ha260182ha'),
            'profile' => 'SuperUser',
            'status' => 'Activo'
        ]);
    }
}
