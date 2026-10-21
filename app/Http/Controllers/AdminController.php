<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Documento;
use App\Models\Pago;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAlumnos = Alumno::count();
        $alumnosActivos = Alumno::where('status', 'Activo')->count();
        $expedientesCompletos = Alumno::where('status_expediente', 'Completo')->count();
        $expedientesIncompletos = Alumno::where('status_expediente', 'Incompleto')->count();
        
        // Datos de pagos individuales
        $totalPagos = Pago::sum('monto');
        $pagosPendientes = Pago::where('status', 'Pendiente')->sum('monto');
        $pagosRealizados = Pago::where('status', 'Pagado')->sum('monto_pagado');
        $pagosParcialesMonto = Pago::where('status', 'Parcial')->sum('monto');
        
        // Datos de montos de inscripción
        $totalMontoInscripcion = Alumno::sum('monto_inscripcion');
        $totalMontoPagado = Alumno::sum('monto_pagado');
        $totalMontoPendiente = $totalMontoInscripcion - $totalMontoPagado;
        
        $documentosPendientes = Documento::where('status', 'Pendiente')->count();
        $documentosEntregados = Documento::where('status', 'Entregado')->count();

        return view('dashboard', [
            'totalAlumnos' => $totalAlumnos,
            'alumnosActivos' => $alumnosActivos,
            'expedientesCompletos' => $expedientesCompletos,
            'expedientesIncompletos' => $expedientesIncompletos,
            'totalPagos' => $totalPagos,
            'pagosPendientes' => $pagosPendientes,
            'pagosRealizados' => $pagosRealizados,
            'pagosParcialesMonto' => $pagosParcialesMonto,
            'totalMontoInscripcion' => $totalMontoInscripcion,
            'totalMontoPagado' => $totalMontoPagado,
            'totalMontoPendiente' => $totalMontoPendiente,
            'documentosPendientes' => $documentosPendientes,
            'documentosEntregados' => $documentosEntregados,
        ]);
    }

    public function inscripciones()
    {
        $alumnos = Alumno::with(['documentos', 'pagos', 'datosBiomedicos'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('inscripciones', [
            'alumnos' => $alumnos,
        ]);
    }

    public function documentos()
    {
        $documentos = Documento::with('alumno')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $documentosPendientes = Documento::where('status', 'Pendiente')->count();
        $documentosEntregados = Documento::where('status', 'Entregado')->count();

        return view('documentos', [
            'documentos' => $documentos,
            'documentosPendientes' => $documentosPendientes,
            'documentosEntregados' => $documentosEntregados,
        ]);
    }

    public function pagos()
    {
        $pagos = Pago::with('alumno')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $pagosPendientes = Pago::where('status', 'Pendiente')->sum('monto');
        $pagosRealizados = Pago::where('status', 'Pagado')->sum('monto');
        $pagosParciales = Pago::where('status', 'Parcial')->count();

        // Datos de montos de inscripción
        $totalMontoInscripcion = Alumno::sum('monto_inscripcion');
        $totalMontoPagado = Alumno::sum('monto_pagado');
        $totalMontoPendiente = $totalMontoInscripcion - $totalMontoPagado;

        return view('pagos', [
            'pagos' => $pagos,
            'pagosPendientes' => $pagosPendientes,
            'pagosRealizados' => $pagosRealizados,
            'pagosParciales' => $pagosParciales,
            'totalMontoInscripcion' => $totalMontoInscripcion,
            'totalMontoPagado' => $totalMontoPagado,
            'totalMontoPendiente' => $totalMontoPendiente,
        ]);
    }

    public function movimientos()
    {
        // Obtener movimientos recientes (últimas actualizaciones de alumnos)
        $movimientos = Alumno::with(['documentos', 'pagos'])
            ->orderBy('updated_at', 'desc')
            ->take(50)
            ->get()
            ->map(function ($alumno) {
                $ultimoDocumento = $alumno->documentos()->latest()->first();
                $ultimoPago = $alumno->pagos()->latest()->first();
                
                $tipo = 'Actualización';
                $descripcion = "Alumno {$alumno->nombre} {$alumno->apellido_paterno} actualizado";
                $fecha = $alumno->updated_at;
                
                if ($ultimoDocumento && $ultimoDocumento->updated_at > $alumno->updated_at) {
                    $tipo = 'Documento';
                    $descripcion = "Documento '{$ultimoDocumento->tipo}' " . ($ultimoDocumento->status == 'Entregado' ? 'entregado' : 'actualizado');
                    $fecha = $ultimoDocumento->updated_at;
                }
                
                if ($ultimoPago && $ultimoPago->updated_at > $fecha) {
                    $tipo = 'Pago';
                    $descripcion = "Pago registrado: {$ultimoPago->concepto} - $" . number_format($ultimoPago->monto_pagado, 2);
                    $fecha = $ultimoPago->updated_at;
                }
                
                return [
                    'alumno' => $alumno,
                    'tipo' => $tipo,
                    'descripcion' => $descripcion,
                    'fecha' => $fecha,
                ];
            })
            ->sortByDesc('fecha')
            ->take(20);

        return view('movimientos', [
            'movimientos' => $movimientos,
        ]);
    }

    public function alumnoDetalle($id)
    {
        $alumno = Alumno::with(['documentos', 'pagos', 'datosBiomedicos', 'movimientos'])
            ->findOrFail($id);

        return view('alumno-detalle', [
            'alumno' => $alumno,
        ]);
    }

    public function alumnoFicha($id)
    {
        $alumno = Alumno::with(['documentos', 'pagos', 'datosBiomedicos'])
            ->findOrFail($id);

        $html = view('alumno-ficha', ['alumno' => $alumno])->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, 'ficha-inscripcion-' . $alumno->matricula . '.html', [
            'Content-Type' => 'text/html; charset=utf-8',
        ]);
    }

    public function alumnoObservacion(Request $request, $id)
    {
        $alumno = Alumno::findOrFail($id);

        $validated = $request->validate([
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $alumno->update($validated);

        return redirect()->route('admin.alumno-detalle', $id)
            ->with('success', 'Comentario administrativo guardado correctamente.');
    }

    public function alumnoEditar($id)
    {
        $alumno = Alumno::findOrFail($id);
        return view('alumno-editar', ['alumno' => $alumno]);
    }

    public function alumnoActualizar(Request $request, $id)
    {
        $alumno = Alumno::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'curp' => 'required|string|max:18|unique:alumnos,curp,' . $id,
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'grado' => 'nullable|string|max:50',
            'grupo' => 'nullable|string|max:50',
            'status' => 'required|in:Activo,Inactivo',
            'status_expediente' => 'required|in:Completo,Incompleto',
            'monto_inscripcion' => 'required|numeric|min:0',
            'monto_pagado' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $alumno->update($validated);

        return redirect()->route('admin.alumno-detalle', $id)
            ->with('success', 'Alumno actualizado correctamente.');
    }
}
