<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Alumno - Sistema de Gestión Administrativa</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-shell">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">🎓</div>
                <div>
                    <strong>Sec. 0383</strong>
                    <span>Vasco de Quiroga</span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="{{ url('/dashboard') }}" class="nav-link">
                    <span class="nav-icon">🏠</span>
                    Dashboard
                </a>
                <a href="{{ url('/inscripciones') }}" class="nav-link active">
                    <span class="nav-icon">📝</span>
                    Inscripciones
                </a>
                <a href="{{ url('/movimientos') }}" class="nav-link">
                    <span class="nav-icon">🔄</span>
                    Movimientos
                </a>
                <a href="{{ url('/pagos') }}" class="nav-link">
                    <span class="nav-icon">💰</span>
                    Pagos
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">Cerrar Sesión</button>
            </form>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <div>
                    <h1>{{ $alumno->nombre }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</h1>
                    <p>Matrícula: <strong>{{ $alumno->matricula }}</strong></p>
                </div>
                <div style="display:flex; gap:10px; align-items:center;">
                    <a href="{{ route('admin.alumno-ficha', $alumno->id) }}" class="btn-header btn-success">Descargar ficha</a>
                    <a href="{{ route('admin.alumno-editar', $alumno->id) }}" class="btn-header">Editar</a>
                </div>
            </header>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="detail-grid">
                <section class="detail-card">
                    <h2>Información Personal</h2>
                    <div class="info-row">
                        <strong>CURP:</strong> {{ $alumno->curp }}
                    </div>
                    <div class="info-row">
                        <strong>Fecha de Nacimiento:</strong> {{ $alumno->fecha_nacimiento?->format('d/m/Y') ?? '-' }}
                    </div>
                    <div class="info-row">
                        <strong>Género:</strong> {{ $alumno->genero ?? '-' }}
                    </div>
                    <div class="info-row">
                        <strong>Teléfono:</strong> {{ $alumno->telefono ?? '-' }}
                    </div>
                    <div class="info-row">
                        <strong>Email:</strong> {{ $alumno->email ?? '-' }}
                    </div>
                    <div class="info-row">
                        <strong>Dirección:</strong> {{ $alumno->direccion ?? '-' }}
                    </div>
                </section>

                <section class="detail-card">
                    <h2>Información Académica</h2>
                    <div class="info-row">
                        <strong>Grado:</strong> {{ $alumno->grado }}
                    </div>
                    <div class="info-row">
                        <strong>Grupo:</strong> {{ $alumno->grupo }}
                    </div>
                    <div class="info-row">
                        <strong>Status:</strong> 
                        <span class="badge badge-{{ strtolower($alumno->status) }}">{{ $alumno->status }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Status Expediente:</strong>
                        <span class="badge badge-{{ strtolower(str_replace(' ', '-', $alumno->status_expediente)) }}">
                            {{ $alumno->status_expediente }}
                        </span>
                    </div>
                    <div class="info-row">
                        <strong>Fecha de Inscripción:</strong> {{ $alumno->fecha_inscripcion->format('d/m/Y') }}
                    </div>
                </section>

                <section class="detail-card">
                    <h2>Información de Pago</h2>
                    <div class="info-row">
                        <strong>Monto de Inscripción:</strong>
                        @if($alumno->monto_inscripcion > 0)
                            <span style="font-weight: 600; color: #333;">${{ number_format($alumno->monto_inscripcion, 2) }}</span>
                        @else
                            <span style="color: #999;">Sin registrar</span>
                        @endif
                    </div>
                    <div class="info-row">
                        <strong>Monto Pagado:</strong>
                        <span style="font-weight: 600; color: #28a745;">${{ number_format($alumno->monto_pagado ?? 0, 2) }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Monto Pendiente:</strong>
                        @php
                            $pendiente = $alumno->monto_inscripcion - ($alumno->monto_pagado ?? 0);
                        @endphp
                        <span style="font-weight: 600; color: {{ $pendiente > 0 ? '#dc3545' : '#28a745' }};">
                            ${{ number_format(max(0, $pendiente), 2) }}
                        </span>
                    </div>
                    <div class="info-row">
                        <strong>Status de Pago:</strong>
                        @if($alumno->monto_inscripcion > 0)
                            @if($alumno->monto_pagado >= $alumno->monto_inscripcion)
                                <span class="badge" style="background: #d4edda; color: #155724;">✓ Pagado</span>
                            @elseif($alumno->monto_pagado > 0)
                                <span class="badge" style="background: #fff3cd; color: #856404;">⏳ Parcial</span>
                            @else
                                <span class="badge" style="background: #f8d7da; color: #721c24;">⚠ Pendiente</span>
                            @endif
                        @else
                            <span class="badge" style="background: #e2e3e5; color: #383d41;">❓ Sin monto</span>
                        @endif
                    </div>
                </section>
            </div>

            <section class="detail-card full">
                <h2>Comentario Administrativo</h2>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="info-row" style="flex-wrap: wrap;">
                    <strong>Observación:</strong>
                    <span style="width:100%; white-space: pre-line;">{{ $alumno->observaciones ?? 'No hay comentarios administrativos.' }}</span>
                </div>
                <form method="POST" action="{{ route('admin.alumno-observacion', $alumno->id) }}" style="margin-top: 15px;">
                    @csrf
                    <div style="margin-bottom: 10px;">
                        <label for="observaciones" style="font-weight: 700; display:block; margin-bottom: 5px;">Escribe un comentario para el alumno</label>
                        <textarea id="observaciones" name="observaciones" rows="4" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">{{ old('observaciones', $alumno->observaciones) }}</textarea>
                        <small>Ej: Falta documentos, falta pago, expediente completo.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar comentario</button>
                </form>
            </section>

            <section class="detail-card full">
                <h2>Datos Biomédicos</h2>
                @if($alumno->datosBiomedicos)
                    <div class="biomedical-grid">
                        <div class="bio-item">
                            <strong>Tipo de Sangre:</strong> {{ $alumno->datosBiomedicos->tipo_sangre ?? '-' }}
                        </div>
                        <div class="bio-item">
                            <strong>Estatura:</strong> {{ $alumno->datosBiomedicos->estatura ?? '-' }} cm
                        </div>
                        <div class="bio-item">
                            <strong>Peso:</strong> {{ $alumno->datosBiomedicos->peso ?? '-' }} kg
                        </div>
                        <div class="bio-item">
                            <strong>Número de Seguro:</strong> {{ $alumno->datosBiomedicos->numero_seguro ?? '-' }}
                        </div>
                        <div class="bio-item">
                            <strong>Alergias:</strong> {{ $alumno->datosBiomedicos->alergias ?? '-' }}
                        </div>
                        <div class="bio-item">
                            <strong>Contacto de Emergencia:</strong> {{ $alumno->datosBiomedicos->contacto_emergencia ?? '-' }}
                        </div>
                    </div>
                @else
                    <p class="empty">No hay datos biomédicos registrados.</p>
                @endif
            </section>

            <section class="detail-card full">
                <h2>Documentos ({{ $alumno->documentos->count() }})</h2>
                @if($alumno->documentos->count())
                    <div class="documents-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Archivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumno->documentos as $doc)
                                    <tr>
                                        <td>{{ $doc->tipo }}</td>
                                        <td><span class="badge badge-{{ strtolower(str_replace(' ', '-', $doc->status)) }}">{{ $doc->status }}</span></td>
                                        <td>{{ $doc->fecha_entrega?->format('d/m/Y') ?? '-' }}</td>
                                        <td>
                                            @if($doc->archivo)
                                                <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">📥 Descargar</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="empty">No hay documentos registrados.</p>
                @endif
            </section>

            <section class="detail-card full">
                <h2>Pagos ({{ $alumno->pagos->count() }})</h2>
                @if($alumno->pagos->count())
                    <div class="payments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Pagado</th>
                                    <th>Método</th>
                                    <th>Status</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumno->pagos as $pago)
                                    <tr>
                                        <td>{{ $pago->concepto }}</td>
                                        <td>${{ number_format($pago->monto, 2) }}</td>
                                        <td>${{ number_format($pago->monto_pagado ?? 0, 2) }}</td>
                                        <td>{{ $pago->metodo_pago }}</td>
                                        <td><span class="badge badge-{{ strtolower(str_replace(' ', '-', $pago->status)) }}">{{ $pago->status }}</span></td>
                                        <td>{{ $pago->fecha->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="empty">No hay pagos registrados.</p>
                @endif
            </section>
        </main>
    </div>

    <style>
        .btn-header {
            background: #007bff;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .btn-header.btn-success {
            background: #28a745;
        }

        .btn-header:hover {
            background: #0056b3;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .detail-card.full {
            grid-column: 1 / -1;
        }

        .detail-card h2 {
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .info-row {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }

        .info-row strong {
            color: #333;
        }

        .biomedical-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .bio-item {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
        }

        .documents-table,
        .payments-table {
            overflow-x: auto;
        }

        .documents-table table,
        .payments-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .documents-table th,
        .payments-table th {
            background: #f5f5f5;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        .documents-table td,
        .payments-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .documents-table tr:hover,
        .payments-table tr:hover {
            background: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .badge-activo {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-inactivo {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-completo {
            background: #d4edda;
            color: #155724;
        }

        .badge-incompleto {
            background: #fff3cd;
            color: #856404;
        }

        .badge-entregado {
            background: #d4edda;
            color: #155724;
        }

        .badge-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .badge-pagado {
            background: #d4edda;
            color: #155724;
        }

        .badge-parcial {
            background: #cce5ff;
            color: #004085;
        }

        .empty {
            color: #999;
            font-style: italic;
            text-align: center;
            padding: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</body>
</html>
