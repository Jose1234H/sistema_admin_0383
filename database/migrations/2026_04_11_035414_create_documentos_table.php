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
        Schema::create('documentos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('alumno_id')->constrained()->onDelete('cascade');

    $table->enum('tipo', [
        'Acta de nacimiento',
        'CURP',
        'Certificado de primaria',
        'Comprobante de domicilio',
        'Certificado medico'
    ]);

    $table->string('archivo')->nullable(); // ruta del archivo

    $table->enum('status', ['Pendiente', 'Entregado'])->default('Pendiente');

    $table->date('fecha_entrega')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
