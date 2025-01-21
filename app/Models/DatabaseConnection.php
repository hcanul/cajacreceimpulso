<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatabaseConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_name',
        'db_name',
        'db_user',
        'db_password',
        'db_host',
        'db_port',
        'db_user_local',
        'db_password_local',
    ];
}
