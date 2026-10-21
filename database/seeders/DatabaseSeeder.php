<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Documento;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
        ]);

        $alumno = Alumno::updateOrCreate([
            'matricula' => '20260001',
        ], [
            'nombre' => 'Diego',
            'apellido_paterno' => 'Ramirez',
            'apellido_materno' => 'Lopez',
            'email' => 'diego.ramirez@example.com',
            'password' => Hash::make('secret123'),
            'status_expediente' => 'Completo',
            'status' => 'Activo',
            'curp' => 'TEST010101HDFRZN09',
            'fecha_nacimiento' => '2002-07-05',
            'genero' => 'Masculino',
            'direccion' => 'Calle Principal 123',
            'telefono' => '7220000000',
            'grado' => '1ro',
            'grupo' => 'A',
            'fecha_inscripcion' => now()->toDateString(),
        ]);

        Documento::factory()->count(4)->create([
            'alumno_id' => $alumno->id,
            'status' => 'Entregado',
        ]);

        Pago::factory()->count(3)->create(['alumno_id' => $alumno->id]);
        Movimiento::factory()->count(2)->create(['alumno_id' => $alumno->id]);

        Alumno::factory(10)->create()->each(function ($alumno) {
            Documento::factory()->count(3)->create(['alumno_id' => $alumno->id]);
            Pago::factory()->count(2)->create(['alumno_id' => $alumno->id]);
            Movimiento::factory()->count(2)->create(['alumno_id' => $alumno->id]);
        });
    }
}
