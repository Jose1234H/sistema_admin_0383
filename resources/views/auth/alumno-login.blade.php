@extends('layouts.auth')

@section('content')
<div class="card alumno">

    <div class="icon">👤</div>

    <h2>Portal del Alumno</h2>
    <p class="subtitle">Inscríbete y consulta tu información</p>

    <div class="list">
        <strong>¿Qué puedes hacer?</strong>
        <ul>
            <li>✔ Registrar tu inscripción completa</li>
            <li>✔ Subir documentos requeridos</li>
            <li>✔ Consultar tu información personal</li>
            <li>✔ Ver historial de pagos</li>
            <li>✔ Verificar estado de expediente</li>
        </ul>
    </div>

    <button class="btn btn-alumno">
        <div class="login-right landing-actions">
            <a href="{{ route('alumno.register') }}" class="landing-button primary">Registrar inscripción</a>
            <a href="{{ route('alumno.access') }}" class="landing-button secondary">Ingresar con matrícula</a>
        </div>
    </div>
    </button>

</div>   
</div>
@endsection