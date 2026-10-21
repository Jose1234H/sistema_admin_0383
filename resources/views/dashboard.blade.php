<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Gestión Administrativa</title>
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
                    <h1>Dashboard</h1>
                    <p>Panel de control y resumen general</p>
                </div>
            </header>

            <section class="summary-grid">
                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Alumnos Inscritos</p>
                            <strong>{{ $totalAlumnos }} <span>/ 120</span></strong>
                        </div>
                        <div class="card-badge blue">👥</div>
                    </div>
                    <div class="progress-wrap">
                        <div class="progress-bar"><span style="width: {{ ($totalAlumnos / 120) * 100 }}%;"></span></div>
                    </div>
                </article>

                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Expedientes Completos</p>
                            <strong>{{ $expedientesCompletos }}</strong>
                        </div>
                        <div class="card-badge green">✓</div>
                    </div>
                </article>

                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Expedientes Incompletos</p>
                            <strong>{{ $expedientesIncompletos }}</strong>
                        </div>
                        <div class="card-badge yellow">!</div>
                    </div>
                </article>

                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Documentos Entregados</p>
                            <strong>{{ $documentosEntregados }}</strong>
                        </div>
                        <div class="card-badge blue">📁</div>
                    </div>
                </article>

                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Documentos Pendientes</p>
                            <strong>{{ $documentosPendientes }}</strong>
                        </div>
                        <div class="card-badge orange">📋</div>
                    </div>
                </article>

                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Total Inscripciones</p>
                            <strong>${{ number_format($totalMontoInscripcion ?? 0, 2) }}</strong>
                        </div>
                        <div class="card-badge blue">$</div>
                    </div>
                </article>

                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Inscripciones Pagadas</p>
                            <strong>${{ number_format($totalMontoPagado ?? 0, 2) }}</strong>
                        </div>
                        <div class="card-badge green">✓</div>
                    </div>
                </article>

                <article class="summary-card">
                    <div class="summary-top">
                        <div>
                            <p class="card-label">Inscripciones Pendientes</p>
                            <strong>${{ number_format($totalMontoPendiente ?? 0, 2) }}</strong>
                        </div>
                        <div class="card-badge red">!</div>
                    </div>
                </article>
            </section>

 <section class="content-grid">    

                <aside class="alerts-card">
                    <div class="section-header">
                        <h2>Alertas Importantes</h2>
                    </div>
                    @if($documentosPendientes > 0)
                        <div class="alert alert-warning">
                            <span>📋</span>
                            <div>
                                <strong>Documentos Pendientes</strong>
                                <p>Hay {{ $documentosPendientes }} documento{{ $documentosPendientes != 1 ? 's' : '' }} que aún no han sido entregados.</p>
                            </div>
                        </div>
                    @endif

                    @if($pagosPendientes > 0)
                        <div class="alert alert-danger">
                            <span>💰</span>
                            <div>
                                <strong>Pagos Pendientes</strong>
                                <p>Total faltante: ${{ number_format($pagosPendientes, 2) }}</p>
                            </div>
                        </div>
                    @endif

                    @if($expedientesIncompletos > 0)
                        <div class="alert alert-warning">
                            <span>📄</span>
                            <div>
                                <strong>Expedientes Incompletos</strong>
                                <p>{{ $expedientesIncompletos }} expediente{{ $expedientesIncompletos != 1 ? 's' : '' }} requieren atención.</p>
                            </div>
                        </div>
                    @endif

                    @if($documentosPendientes == 0 && $pagosPendientes == 0 && $expedientesIncompletos == 0)
                        <div class="alert alert-success">
                            <span>✓</span>
                            <div>
                                <strong>Sistema en Orden</strong>
                                <p>Todo está al día. No hay alertas pendientes.</p>
                            </div>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <span>ℹ️</span>
                        <div>
                            <strong>Meta de Inscripción</strong>
                            <p>{{ 120 - $totalAlumnos }} alumno{{ (120 - $totalAlumnos) != 1 ? 's' : '' }} faltante{{ (120 - $totalAlumnos) != 1 ? 's' : '' }} para completar la meta de 120.</p>
                        </div>
                    </div>
                </aside>
            </section>
        </main>
    </div>
</body>
</html>
