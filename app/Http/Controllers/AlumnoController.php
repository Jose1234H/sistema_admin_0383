<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Documento;
use App\Models\Pago;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    public function welcome()
    {
        return view('auth.alumno-login');
    }

    public function showRegister()
    {
        return view('auth.alumno-register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'curp' => 'required|string|max:18|unique:alumnos,curp',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'grado' => 'nullable|string|max:50',
            'grupo' => 'nullable|string|max:50',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Generar matrícula automáticamente
        $ultimoAlumno = Alumno::orderBy('id', 'desc')->first();
        $numeroMatricula = ($ultimoAlumno ? intval(substr($ultimoAlumno->matricula, -5)) : 0) + 1;
        $validated['matricula'] = 'ALU' . str_pad($numeroMatricula, 5, '0', STR_PAD_LEFT);

        $validated['password'] = Hash::make($validated['password']);
        $validated['fecha_inscripcion'] = now()->toDateString();
        $validated['status'] = 'Activo';
        $validated['status_expediente'] = 'Incompleto';

        Alumno::create($validated);

        return redirect()->route('alumno.access')
            ->with('success', 'Registro completado. Tu matrícula es: ' . $validated['matricula'] . '. Ahora ingresa con tu matrícula y contraseña.');
    }

    public function showAccess()
    {
        return view('auth.alumno-access');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'matricula' => 'required|string',
            'password' => 'required|string',
        ]);

        $alumno = Alumno::where('matricula', $credentials['matricula'])->first();

        if (! $alumno || ! Hash::check($credentials['password'], $alumno->password)) {
            return back()->withErrors(['matricula' => 'Matrícula o contraseña incorrecta'])->onlyInput('matricula');
        }

        session(['alumno_id' => $alumno->id]);

        return redirect()->route('alumno.dashboard');
    }

    public function logout(): RedirectResponse
    {
        session()->forget('alumno_id');

        return redirect()->route('alumno.access');
    }

    protected function currentAlumno(): ?Alumno
    {
        if (! session()->has('alumno_id')) {
            return null;
        }

        return Alumno::with(['documentos', 'pagos', 'movimientos', 'datosBiomedicos'])
            ->find(session('alumno_id'));
    }

    public function dashboard()
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        // Calcular pagos pendientes basado en monto de inscripción
        $montoPendiente = 0;
        if ($alumno->monto_inscripcion && $alumno->monto_inscripcion > $alumno->monto_pagado) {
            $montoPendiente = $alumno->monto_inscripcion - $alumno->monto_pagado;
        }

        return view('alumno.dashboard', [
            'alumno' => $alumno,
            'documentsPending' => $alumno->documentos()->where('status', 'Pendiente')->count(),
            'paymentsPending' => $montoPendiente > 0 ? 1 : 0, // 1 si hay monto pendiente, 0 si no
            'pendingCount' => $alumno->documentos()->where('status', 'Pendiente')->count() + ($montoPendiente > 0 ? 1 : 0),
        ]);
    }

    public function inscripciones()
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        return view('alumno.inscripciones', [
            'alumno' => $alumno,
        ]);
    }

    public function documentos()
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        // Ensure all required documents exist
        $requiredDocuments = [
            'Acta de nacimiento',
            'CURP',
            'Certificado de primaria',
            'Comprobante de domicilio',
            'Certificado medico'
        ];

        foreach ($requiredDocuments as $tipo) {
            $alumno->documentos()->firstOrCreate(['tipo' => $tipo]);
        }

        return view('alumno.documentos', [
            'alumno' => $alumno,
            'documentos' => $alumno->documentos()->orderBy('tipo')->get(),
        ]);
    }

    public function pagos()
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        return view('alumno.pagos', [
            'alumno' => $alumno,
            'pagos' => $alumno->pagos,
        ]);
    }

    public function datosBiomedicos()
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        return view('alumno.datos-biomedicos', [
            'alumno' => $alumno,
            'datosBiomedicos' => $alumno->datosBiomedicos,
        ]);
    }

    public function updateDatosBiomedicos(Request $request)
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        $validated = $request->validate([
            'tipo_sangre' => 'nullable|string|max:10',
            'estatura' => 'nullable|numeric|min:0|max:300',
            'peso' => 'nullable|numeric|min:0|max:500',
            'numero_seguro' => 'nullable|string|max:50',
            'alergias' => 'nullable|string',
            'contacto_emergencia' => 'nullable|string|max:255',
        ]);

        $alumno->datosBiomedicos()->updateOrCreate(
            ['alumno_id' => $alumno->id],
            $validated
        );

        return redirect()->route('alumno.datos-biomedicos')->with('success', 'Datos biomédicos actualizados correctamente.');
    }

    public function perfil()
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        return view('alumno.perfil', [
            'alumno' => $alumno,
        ]);
    }

    public function uploadDocumento(Request $request, $documentoId)
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        $documento = Documento::where('id', $documentoId)
            ->where('alumno_id', $alumno->id)
            ->first();

        if (! $documento) {
            return redirect()->route('alumno.documentos')->with('error', 'Documento no encontrado.');
        }

        $validated = $request->validate([
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        if ($documento->archivo && Storage::exists($documento->archivo)) {
            Storage::delete($documento->archivo);
        }

        $path = $request->file('archivo')->store('documentos/' . $alumno->id, 'public');

        $documento->update([
            'archivo' => $path,
            'status' => 'Entregado',
            'fecha_entrega' => now()->toDateString(),
        ]);

        return redirect()->route('alumno.documentos')->with('success', 'Documento cargado exitosamente.');
    }

    public function storePago(Request $request)
    {
        $alumno = $this->currentAlumno();
        if (! $alumno) {
            return redirect()->route('alumno.access');
        }

        $validated = $request->validate([
            'concepto' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0.01',
            'monto_pagado' => 'nullable|numeric|min:0',
            'metodo_pago' => 'required|string|max:100',
            'folio' => 'nullable|string|max:100',
            'fecha' => 'required|date',
        ]);

        $validated['alumno_id'] = $alumno->id;
        $validated['monto_pagado'] = $validated['monto_pagado'] ?? $validated['monto'];

        // Determine status based on payment amount
        $montoTotal = $validated['monto'];
        $montoPagado = $validated['monto_pagado'];

        if ($montoPagado >= $montoTotal) {
            $validated['status'] = 'Pagado';
        } elseif ($montoPagado > 0) {
            $validated['status'] = 'Parcial';
        } else {
            $validated['status'] = 'Pendiente';
        }

        Pago::create($validated);

        // Actualizar el monto_pagado del alumno si el pago es por "Inscripción"
        $conceptoLimpio = strtolower(trim($validated['concepto']));
        if (str_contains($conceptoLimpio, 'inscrip')) {
            $alumno->increment('monto_pagado', $montoPagado);
        }

        return redirect()->route('alumno.pagos')->with('success', 'Pago registrado exitosamente.');
    }
}
