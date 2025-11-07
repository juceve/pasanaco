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
        Schema::create('sesioncronogramas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesions')->cascadeOnDelete();
            $table->date('fecha');
            $table->string('observaciones')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->decimal('monto_entregado', 10, 2)->default(0);
            $table->boolean('procesado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesioncronogramas');
    }
};
