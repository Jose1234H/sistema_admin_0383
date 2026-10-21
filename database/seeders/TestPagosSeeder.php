<?php

namespace Database\Seeders;

use App\Models\Alumno;
use Illuminate\Database\Seeder;

class TestPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar un alumno existente o crear uno de prueba
        $alumno = Alumno::where('matricula', 'TEST001')->first();

        if (!$alumno) {
            $alumno = Alumno::create([
                'matricula' => 'TEST001',
                'nombre' => 'Alumno',
                'apellido_paterno' => 'de',
                'apellido_materno' => 'Prueba',
                'curp' => 'TESTCURP123456789',
                'fecha_nacimiento' => '2010-01-01',
                'genero' => 'Masculino',
                'direccion' => 'Dirección de prueba',
                'telefono' => '5551234567',
                'email' => 'test@example.com',
                'grado' => '1ro',
                'grupo' => 'A',
                'password' => bcrypt('password'),
                'status' => 'Activo',
                'status_expediente' => 'Completo',
                'fecha_inscripcion' => now(),
                'monto_inscripcion' => 700.00,
                'monto_pagado' => 500.00,
            ]);
        } else {
            // Actualizar montos de prueba
            $alumno->update([
                'monto_inscripcion' => 700.00,
                'monto_pagado' => 500.00,
            ]);
        }

        $this->command->info('Alumno de prueba creado/actualizado:');
        $this->command->info('Matrícula: TEST001');
        $this->command->info('Monto inscripción: $700.00');
        $this->command->info('Monto pagado: $500.00');
        $this->command->info('Monto pendiente: $200.00');
    }
}