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
        Schema::create('datos_biomedicos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('alumno_id')->constrained()->onDelete('cascade');

    $table->string('tipo_sangre')->nullable();
    $table->float('estatura')->nullable();
    $table->float('peso')->nullable();
    $table->string('numero_seguro')->nullable();
    $table->text('alergias')->nullable();
    $table->string('contacto_emergencia')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_biomedicos');
    }
};
