<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('database_connections', function (Blueprint $table) {
            $table->string('db_user_local')->default('root');
            $table->string('db_password_local')->default('root');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('database_connections', function (Blueprint $table) {
            $table->dropColumn('db_user_local');
            $table->dropColumn('db_password_local');
        });
    }
};
