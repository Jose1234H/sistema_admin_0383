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
        Schema::create('pagos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('alumno_id')->constrained()->onDelete('cascade');

    $table->string('concepto');
    $table->decimal('monto', 10, 2);
    $table->decimal('monto_pagado', 10, 2)->nullable();

    $table->enum('status', ['Pagado', 'Pendiente', 'Parcial'])->default('Pendiente');

    $table->string('metodo_pago');
    $table->string('folio')->nullable();

    $table->date('fecha');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
