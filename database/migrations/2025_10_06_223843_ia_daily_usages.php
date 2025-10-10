<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ia_daily_usages', function (Blueprint $table) {
            // Usamos un ID fijo (1) para tener un único registro de contador global.
            $table->id();
            // Contador de peticiones realizadas hoy.
            $table->unsignedBigInteger('request_count')->default(0);
            // Fecha usada para determinar cuándo se debe resetear el contador.
            $table->date('last_reset_date');
            $table->timestamps();
        });

        // Inserta el registro inicial para que la tabla siempre tenga un contador.
        DB::table('ia_daily_usages')->insert([
            'id' => 1,
            'request_count' => 0,
            'last_reset_date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
