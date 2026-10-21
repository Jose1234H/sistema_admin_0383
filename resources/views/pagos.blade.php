<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos - Sistema de Gestión Administrativa</title>
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
                    <h1>Pagos</h1>
                    <p>Administra los pagos y estados de cobro.</p>
                </div>
            </header>

            

                <article class="activity-card">
                    <div class="section-header">
                        <h2>Historial de Pagos</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Alumno</th>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Pagado</th>
                                    <th>Faltante</th>
                                    <th>Método</th>
                                    <th>Status</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pagos as $pago)
                                    <tr>
                                        <td>
                                            <strong>{{ $pago->alumno->nombre }}</strong>
                                            <br>
                                            <small>{{ $pago->alumno->matricula }}</small>
                                        </td>
                                        <td>{{ $pago->concepto }}</td>
                                        <td>${{ number_format($pago->monto, 2) }}</td>
                                        <td>${{ number_format($pago->monto_pagado ?? 0, 2) }}</td>
                                        <td>${{ number_format(($pago->monto) - ($pago->monto_pagado ?? 0), 2) }}</td>
                                        <td>{{ $pago->metodo_pago }}</td>
                                        <td>
                                            <span class="badge badge-{{ strtolower(str_replace(' ', '-', $pago->status)) }}">
                                                {{ $pago->status }}
                                            </span>
                                        </td>
                                        <td>{{ $pago->fecha->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay pagos registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($pagos->hasPages())
                        <div class="pagination-wrap">
                            {{ $pagos->links() }}
                        </div>
                    @endif
                </article>
            </section>

            <style>
                .summary-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 15px;
                    margin-bottom: 20px;
                }

                .summary-item {
                    background: #f5f5f5;
                    padding: 15px;
                    border-radius: 8px;
                    text-align: center;
                }

                .amount {
                    display: block;
                    font-size: 1.8em;
                    font-weight: 700;
                    color: #dc3545;
                    margin-top: 5px;
                }

                .amount.success {
                    color: #28a745;
                }

                .amount.warning {
                    color: #ffc107;
                }

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

                .badge-pagado {
                    background: #d4edda;
                    color: #155724;
                }

                .badge-pendiente {
                    background: #fff3cd;
                    color: #856404;
                }

                .badge-parcial {
                    background: #cce5ff;
                    color: #004085;
                }

                .text-center {
                    text-align: center;
                }

                .pagination-wrap {
                    margin-top: 20px;
                }
            </style>
        </main>
    </div>
</body>
</html>
