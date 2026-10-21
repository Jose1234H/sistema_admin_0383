<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos - Sistema de Gestión Administrativa</title>
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
                    <h1>Movimientos</h1>
                    <p>Revisa los movimientos administrativos y actualizaciones.</p>
                </div>
            </header>

            <section class="content-grid">
                <article class="activity-card">
                    <div class="section-header">
                        <h2>Últimos Movimientos</h2>
                    </div>
                    <div class="activity-list">
                        @forelse($movimientos as $movimiento)
                            <div class="activity-item">
                                <div class="activity-icon">
                                    @if($movimiento['tipo'] == 'Pago')
                                        💰
                                    @elseif($movimiento['tipo'] == 'Documento')
                                        📄
                                    @else
                                        🔄
                                    @endif
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">
                                        <strong>{{ $movimiento['alumno']->matricula }}</strong> - {{ $movimiento['alumno']->nombre }} {{ $movimiento['alumno']->apellido_paterno }}
                                    </div>
                                    <div class="activity-description">{{ $movimiento['descripcion'] }}</div>
                                    <div class="activity-meta">
                                        <span class="activity-type">{{ $movimiento['tipo'] }}</span>
                                        <span class="activity-date">{{ $movimiento['fecha']->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <p>No hay movimientos recientes.</p>
                            </div>
                        @endforelse
                    </div>
                </article>
            </section>
        </main>
    </div>

    <style>
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            gap: 15px;
        }

        .activity-icon {
            font-size: 1.5em;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .activity-description {
            color: #666;
            margin-bottom: 8px;
        }

        .activity-meta {
            display: flex;
            gap: 15px;
            font-size: 0.9em;
            color: #999;
        }

        .activity-type {
            background: #f0f0f0;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state p {
            margin: 0;
            font-size: 1.1em;
        }
    </style>
</body>
</html>
