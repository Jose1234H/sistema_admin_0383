<aside class="portal-sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">👩‍🎓</div>
        <div>
            <strong>Portal Alumno</strong>
            <span>Sec. 0383</span>
        </div>
    </div>

    <nav class="portal-nav">
        <a href="{{ route('alumno.dashboard') }}" class="portal-link {{ request()->routeIs('alumno.dashboard') ? 'active' : '' }}">
            <span>🏠</span>
            Dashboard
        </a>
        <a href="{{ route('alumno.inscripciones') }}" class="portal-link {{ request()->routeIs('alumno.inscripciones') ? 'active' : '' }}">
            <span>📝</span>
            Inscripciones
        </a>
        <a href="{{ route('alumno.documentos') }}" class="portal-link {{ request()->routeIs('alumno.documentos') ? 'active' : '' }}">
            <span>📁</span>
            Documentos
        </a>
        <a href="{{ route('alumno.datos-biomedicos') }}" class="portal-link {{ request()->routeIs('alumno.datos-biomedicos') ? 'active' : '' }}">
            <span>🏥</span>
            Datos Biomédicos
        </a>
        <a href="{{ route('alumno.pagos') }}" class="portal-link {{ request()->routeIs('alumno.pagos') ? 'active' : '' }}">
            <span>💵</span>
            Pagos
        </a>
        <a href="{{ route('alumno.perfil') }}" class="portal-link {{ request()->routeIs('alumno.perfil') ? 'active' : '' }}">
            <span>👤</span>
            Perfil
        </a>
    </nav>

    <form method="POST" action="{{ route('alumno.logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="sidebar-logout">Cerrar sesión</button>
    </form>
</aside>
