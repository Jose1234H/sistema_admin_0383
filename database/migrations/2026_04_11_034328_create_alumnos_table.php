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
        Schema::create('alumnos', function (Blueprint $table) {
    $table->id();
    $table->string('matricula')->unique();
    $table->string('nombre');
    $table->string('apellido_paterno');
    $table->string('apellido_materno')->nullable();
    $table->string('curp')->unique();
    $table->date('fecha_nacimiento')->nullable();
    $table->string('genero')->nullable();
    $table->text('direccion')->nullable();
    $table->string('telefono')->nullable();
    $table->string('email')->nullable();
    $table->string('grado')->nullable();
    $table->string('grupo')->nullable();

    $table->enum('status', ['Activo', 'Inactivo'])->default('Activo');
    $table->enum('status_expediente', ['Completo', 'Incompleto'])->default('Incompleto');

    $table->date('fecha_inscripcion')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
