<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripciones - Sistema de Gestión Administrativa</title>
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
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">🏠</span>
                    Dashboard
                </a>
                <a href="{{ url('/inscripciones') }}" class="nav-link {{ request()->is('inscripciones') ? 'active' : '' }}">
                    <span class="nav-icon">📝</span>
                    Inscripciones
                </a>
                <a href="{{ url('/documentos') }}" class="nav-link {{ request()->is('documentos') ? 'active' : '' }}">
                    <span class="nav-icon">📄</span>
                    Documentos
                </a>
                <a href="{{ url('/movimientos') }}" class="nav-link {{ request()->is('movimientos') ? 'active' : '' }}">
                    <span class="nav-icon">🔄</span>
                    Movimientos
                </a>
                <a href="{{ url('/pagos') }}" class="nav-link {{ request()->is('pagos') ? 'active' : '' }}">
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
                    <h1>Inscripciones</h1>
                    <p>Administra y revisa los registros de inscripción.</p>
                </div>
            </header>

            <section class="content-grid" style="grid-template-columns: 1fr;">
                <aside class="alerts-card" style="margin-bottom: 20px;">
                    <div class="section-header">
                        <h2>Resumen de Inscripciones</h2>
                    </div>
                    <div class="summary-info">
                        <div class="info-item">
                            <span class="label">Total de Alumnos:</span>
                            <span class="value">{{ $alumnos->total() }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Expedientes Completos:</span>
                            <span class="value success">{{ $alumnos->count() > 0 ? $alumnos->where('status_expediente', 'Completo')->count() : 0 }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Expedientes Incompletos:</span>
                            <span class="value danger">{{ $alumnos->count() > 0 ? $alumnos->where('status_expediente', 'Incompleto')->count() : 0 }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Alumnos Activos:</span>
                            <span class="value">{{ $alumnos->count() > 0 ? $alumnos->where('status', 'Activo')->count() : 0 }}</span>
                        </div>
                    </div>
                    
                    <div class="section-header" style="margin-top: 20px;">
                        <h3>Resumen Financiero</h3>
                    </div>
                    <div class="summary-info">
                        <div class="info-item">
                            <span class="label">Total a Cobrar:</span>
                            <span class="value">${{ number_format($alumnos->sum('monto_inscripcion') ?? 0, 2) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Total Pagado:</span>
                            <span class="value success">${{ number_format($alumnos->sum('monto_pagado') ?? 0, 2) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Total Pendiente:</span>
                            <span class="value danger">${{ number_format(($alumnos->sum('monto_inscripcion') ?? 0) - ($alumnos->sum('monto_pagado') ?? 0), 2) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">% Pagado:</span>
                            <span class="value">
                                @php
                                    $totalACobrar = $alumnos->sum('monto_inscripcion') ?? 0;
                                    $totalPagado = $alumnos->sum('monto_pagado') ?? 0;
                                    $porcentaje = $totalACobrar > 0 ? ($totalPagado / $totalACobrar) * 100 : 0;
                                @endphp
                                {{ number_format($porcentaje, 1) }}%
                            </span>
                        </div>
                    </div>
                </aside>

                <article class="activity-card">
                    <div class="section-header">
                        <h2>Lista de Alumnos Inscritos</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Matrícula</th>
                                    <th>Nombre</th>
                                    <th>Grado/Grupo</th>
                                    <th>Monto Inscripción</th>
                                    <th>Pagado</th>
                                    <th>Faltante</th>
                                    <th>Status Pago</th>
                                    <th>Expediente</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alumnos as $alumno)
                                    @php
                                        $montoFaltante = $alumno->monto_inscripcion - $alumno->monto_pagado;
                                        $statusPago = $alumno->monto_pagado >= $alumno->monto_inscripcion ? 'Pagado' : ($alumno->monto_pagado > 0 ? 'Parcial' : 'Pendiente');
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $alumno->matricula }}</strong></td>
                                        <td>{{ $alumno->nombre }} {{ $alumno->apellido_paterno }}</td>
                                        <td>{{ $alumno->grado }}/{{ $alumno->grupo }}</td>
                                        <td>
                                            <span class="monto-inscripcion">
                                                @if($alumno->monto_inscripcion > 0)
                                                    ${{ number_format($alumno->monto_inscripcion, 2) }}
                                                @else
                                                    <span class="text-muted">Sin registrar</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="monto-pagado">
                                                ${{ number_format($alumno->monto_pagado ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="monto-faltante {{ $montoFaltante > 0 ? 'text-danger' : 'text-success' }}">
                                                ${{ number_format(max(0, $montoFaltante), 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ strtolower(str_replace(' ', '-', $statusPago)) }}">
                                                {{ $statusPago }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ strtolower(str_replace(' ', '-', $alumno->status_expediente)) }}">
                                                {{ $alumno->status_expediente }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group-small">
                                                <a href="{{ route('admin.alumno-detalle', $alumno->id) }}" class="btn-small btn-info" title="Ver detalles">👁️</a>
                                                <a href="{{ route('admin.alumno-ficha', $alumno->id) }}" class="btn-small btn-success" title="Descargar ficha">⬇️</a>
                                                <a href="{{ route('admin.alumno-editar', $alumno->id) }}" class="btn-small btn-warning" title="Editar">✏️</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No hay alumnos registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($alumnos->hasPages())
                        <div class="pagination-wrap">
                            {{ $alumnos->links() }}
                        </div>
                    @endif
                </article>
            </section>

            <style>
                .table-responsive {
                    overflow-x: auto;
                }

                .data-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }

                .data-table th {
                    background: #f5f5f5;
                    padding: 12px;
                    text-align: left;
                    font-weight: 600;
                    border-bottom: 2px solid #ddd;
                }

                .data-table td {
                    padding: 12px;
                    border-bottom: 1px solid #eee;
                }

                .data-table tr:hover {
                    background: #f9f9f9;
                }

                .badge {
                    display: inline-block;
                    padding: 5px 10px;
                    border-radius: 5px;
                    font-size: 0.85em;
                    font-weight: 600;
                }

                .badge-completo {
                    background: #d4edda;
                    color: #155724;
                }

                .badge-incompleto {
                    background: #fff3cd;
                    color: #856404;
                }

                .badge-activo {
                    background: #d1ecf1;
                    color: #0c5460;
                }

                .badge-inactivo {
                    background: #f8d7da;
                    color: #721c24;
                }

                .btn-small {
                    display: inline-block;
                    padding: 5px 10px;
                    background: #007bff;
                    color: white;
                    text-decoration: none;
                    border-radius: 3px;
                    font-size: 0.85em;
                    margin-right: 5px;
                }

                .btn-small:hover {
                    background: #0056b3;
                }

                .text-center {
                    text-align: center;
                }

                .monto-inscripcion {
                    font-weight: 600;
                    color: #333;
                }

                .monto-pagado {
                    color: #28a745;
                    font-weight: 600;
                }

                .monto-faltante {
                    font-weight: 600;
                }

                .text-danger {
                    color: #dc3545;
                }

                .text-success {
                    color: #28a745;
                }

                .text-muted {
                    color: #999;
                    font-style: italic;
                }

                .btn-group-small {
                    display: flex;
                    gap: 5px;
                }

                .btn-small.btn-info {
                    background: #17a2b8;
                }

                .btn-small.btn-info:hover {
                    background: #138496;
                }

                .btn-small.btn-warning {
                    background: #ffc107;
                    color: #212529;
                }

                .btn-small.btn-warning:hover {
                    background: #e0a800;
                }

                .badge-pagado {
                    background: #d4edda;
                    color: #155724;
                }

                .badge-parcial {
                    background: #fff3cd;
                    color: #856404;
                }

                .badge-pendiente {
                    background: #f8d7da;
                    color: #721c24;
                }
            </style>
        </main>
    </div>
</body>
</html>
