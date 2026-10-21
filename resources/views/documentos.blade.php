<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos - Sistema de Gestión Administrativa</title>
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
                    <h1>Documentos</h1>
                    <p>Administra y revisa el estado de todos los documentos.</p>
                </div>
            </header>

            <section class="content-grid" style="grid-template-columns: 1fr;">
                <aside class="alerts-card" style="margin-bottom: 20px;">
                    <div class="section-header">
                        <h2>Resumen de Documentos</h2>
                    </div>
                    <div class="summary-info">
                        <div class="info-item">
                            <span class="label">Total de Documentos:</span>
                            <span class="value">{{ $documentos->total() }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Documentos Entregados:</span>
                            <span class="value success">{{ $documentosEntregados }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Documentos Pendientes:</span>
                            <span class="value danger">{{ $documentosPendientes }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">% Completado:</span>
                            <span class="value">
                                @php
                                    $totalDocs = $documentos->total();
                                    $porcentajeCompletado = $totalDocs > 0 ? ($documentosEntregados / $totalDocs) * 100 : 0;
                                @endphp
                                {{ number_format($porcentajeCompletado, 1) }}%
                            </span>
                        </div>
                    </div>
                </aside>

                <article class="activity-card">
                    <div class="section-header">
                        <h2>Lista de Documentos</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Alumno</th>
                                    <th>Tipo de Documento</th>
                                    <th>Status</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Archivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documentos as $documento)
                                    <tr>
                                        <td>
                                            <strong>{{ $documento->alumno->matricula }}</strong>
                                            <br>
                                            <small>{{ $documento->alumno->nombre }} {{ $documento->alumno->apellido_paterno }}</small>
                                        </td>
                                        <td>{{ $documento->tipo }}</td>
                                        <td>
                                            <span class="badge badge-{{ strtolower(str_replace(' ', '-', $documento->status)) }}">
                                                {{ $documento->status }}
                                            </span>
                                        </td>
                                        <td>{{ $documento->fecha_entrega?->format('d/m/Y') ?? '-' }}</td>
                                        <td>
                                            @if($documento->archivo)
                                                <a href="{{ asset('storage/' . $documento->archivo) }}" target="_blank" class="btn-small">📥 Ver</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay documentos registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($documentos->hasPages())
                        <div class="pagination-wrap">
                            {{ $documentos->links() }}
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

                .badge-entregado {
                    background: #d4edda;
                    color: #155724;
                }

                .badge-pendiente {
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
                }

                .btn-small:hover {
                    background: #0056b3;
                }

                .text-center {
                    text-align: center;
                }
            </style>
        </main>
    </div>
</body>
</html>