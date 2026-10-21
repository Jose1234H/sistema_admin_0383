<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Inscripción - {{ $alumno->nombre }} {{ $alumno->apellido_paterno }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; margin: 0; padding: 0; background: #f5f5f5; }
        .ficha { max-width: 1080px; margin: 20px auto; background: #fff; padding: 24px; border: 1px solid #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; letter-spacing: 0.05em; }
        .subtitle { font-size: 14px; margin-top: 8px; color: #555; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; border-bottom: 2px solid #000; padding-bottom: 4px; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(200px, 1fr)); gap: 12px; }
        .field { background: #fff; padding: 10px; border: 1px solid #000; min-height: 55px; }
        .field span.label { display: block; font-weight: bold; font-size: 12px; margin-bottom: 4px; color: #333; }
        .field span.value { display: block; font-size: 14px; color: #111; }
        .full-width { grid-column: 1 / -1; }
        .table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .table th, .table td { border: 1px solid #000; padding: 8px 10px; text-align: left; font-size: 13px; }
        .table th { background: #e9ecef; }
        .notes { white-space: pre-line; padding: 10px; border: 1px solid #000; min-height: 80px; background: #f8f9fa; }
        .small-text { font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="ficha">
        <div class="header">
            <h1>FICHA DE INSCRIPCIÓN</h1>
            <p class="subtitle">SECUNDARIA 0383 - Vasco de Quiroga</p>
        </div>

        <section class="section">
            <div class="section-title">Datos del Alumno</div>
            <div class="grid">
                <div class="field"><span class="label">Matrícula</span><span class="value">{{ $alumno->matricula }}</span></div>
                <div class="field"><span class="label">CURP</span><span class="value">{{ $alumno->curp }}</span></div>
                <div class="field"><span class="label">Nombre</span><span class="value">{{ $alumno->nombre }}</span></div>
                <div class="field"><span class="label">Apellido Paterno</span><span class="value">{{ $alumno->apellido_paterno }}</span></div>
                <div class="field"><span class="label">Apellido Materno</span><span class="value">{{ $alumno->apellido_materno ?? '-' }}</span></div>
                <div class="field"><span class="label">Fecha de Nacimiento</span><span class="value">{{ optional($alumno->fecha_nacimiento)->format('d/m/Y') ?? '-' }}</span></div>
                <div class="field"><span class="label">Género</span><span class="value">{{ $alumno->genero ?? '-' }}</span></div>
                <div class="field"><span class="label">Teléfono</span><span class="value">{{ $alumno->telefono ?? '-' }}</span></div>
                <div class="field full-width"><span class="label">Dirección</span><span class="value">{{ $alumno->direccion ?? '-' }}</span></div>
                <div class="field"><span class="label">Email</span><span class="value">{{ $alumno->email ?? '-' }}</span></div>
            </div>
        </section>

        <section class="section">
            <div class="section-title">Información Académica</div>
            <div class="grid">
                <div class="field"><span class="label">Grado</span><span class="value">{{ $alumno->grado ?? '-' }}</span></div>
                <div class="field"><span class="label">Grupo</span><span class="value">{{ $alumno->grupo ?? '-' }}</span></div>
                <div class="field"><span class="label">Status</span><span class="value">{{ $alumno->status ?? '-' }}</span></div>
                <div class="field"><span class="label">Expediente</span><span class="value">{{ $alumno->status_expediente ?? '-' }}</span></div>
                <div class="field"><span class="label">Fecha de Inscripción</span><span class="value">{{ optional($alumno->fecha_inscripcion)->format('d/m/Y') ?? '-' }}</span></div>
            </div>
        </section>

        <section class="section">
            <div class="section-title">Pago de Inscripción</div>
            <div class="grid">
                <div class="field"><span class="label">Monto Inscripción</span><span class="value">${{ number_format($alumno->monto_inscripcion ?? 0, 2) }}</span></div>
                <div class="field"><span class="label">Monto Pagado</span><span class="value">${{ number_format($alumno->monto_pagado ?? 0, 2) }}</span></div>
                <div class="field"><span class="label">Monto Pendiente</span><span class="value">${{ number_format(max(0, ($alumno->monto_inscripcion ?? 0) - ($alumno->monto_pagado ?? 0)), 2) }}</span></div>
            </div>
        </section>

        <section class="section">
            <div class="section-title">Observaciones administrativas</div>
            <div class="notes">{{ $alumno->observaciones ?? 'No hay observaciones registradas.' }}</div>
        </section>

        <section class="section">
            <div class="section-title">Datos Biomédicos</div>
            <div class="grid">
                <div class="field"><span class="label">Tipo de Sangre</span><span class="value">{{ $alumno->datosBiomedicos->tipo_sangre ?? '-' }}</span></div>
                <div class="field"><span class="label">Peso</span><span class="value">{{ $alumno->datosBiomedicos->peso ?? '-' }} kg</span></div>
                <div class="field"><span class="label">Estatura</span><span class="value">{{ $alumno->datosBiomedicos->estatura ?? '-' }} cm</span></div>
                <div class="field"><span class="label">Seguro</span><span class="value">{{ $alumno->datosBiomedicos->numero_seguro ?? '-' }}</span></div>
                <div class="field full-width"><span class="label">Alergias / Emergencia</span><span class="value">{{ $alumno->datosBiomedicos->alergias ?? '-' }} / {{ $alumno->datosBiomedicos->contacto_emergencia ?? '-' }}</span></div>
            </div>
        </section>

        <section class="section">
            <div class="section-title">Documentos registrados</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Fecha entrega</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumno->documentos as $documento)
                        <tr>
                            <td>{{ $documento->tipo }}</td>
                            <td>{{ $documento->status }}</td>
                            <td>{{ optional($documento->fecha_entrega)->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay documentos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="section">
            <div class="section-title">Pagos registrados</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Pagado</th>
                        <th>Status</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumno->pagos as $pago)
                        <tr>
                            <td>{{ $pago->concepto }}</td>
                            <td>${{ number_format($pago->monto, 2) }}</td>
                            <td>${{ number_format($pago->monto_pagado ?? 0, 2) }}</td>
                            <td>{{ $pago->status }}</td>
                            <td>{{ optional($pago->fecha)->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay pagos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <p class="small-text">Este documento fue generado automáticamente desde el sistema de gestión administrativa.</p>
    </div>
</body>
</html>
