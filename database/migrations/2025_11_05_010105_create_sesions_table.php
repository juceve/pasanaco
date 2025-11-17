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
        Schema::create('sesions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_sesion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->decimal('cuota', 10, 2);
            $table->string('qrcobro')->nullable();
            $table->foreignId('modo_id')->nullable()->constrained('modos')->nullOnDelete();
            $table->enum('estado',['CREADO', 'SORTEADO','EN_PROGRESO','FINALIZADO','ANULADO'])->default('CREADO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesions');
    }
};
