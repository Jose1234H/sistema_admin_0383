@extends('layouts.alumno')

@section('content')
<div class="portal-shell">
    @include('alumno.partials.sidebar')

    <main class="main-panel">
        <div class="page-title">
            <div>
                <h1>Perfil</h1>
                <p>Revisa tus datos personales y mantén tu información actualizada.</p>
            </div>
        </div>

        <div class="profile-grid">
            <div class="profile-card">
                <div>
                    <strong>Nombre</strong>
                    <span>{{ $alumno->nombre }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</span>
                </div>
                <div>
                    <strong>Correo</strong>
                    <span>{{ $alumno->email ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong>Matrícula</strong>
                    <span>{{ $alumno->matricula }}</span>
                </div>
            </div>

            <div class="profile-card">
                <div>
                    <strong>CURP</strong>
                    <span>{{ $alumno->curp }}</span>
                </div>
                <div>
                    <strong>Teléfono</strong>
                    <span>{{ $alumno->telefono ?? 'No registrado' }}</span>
                </div>
                <div>
                    <strong>Grado</strong>
                    <span>{{ $alumno->grado ?? 'No registrado' }} {{ $alumno->grupo ?? '' }}</span>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection