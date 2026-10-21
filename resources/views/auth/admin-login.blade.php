@extends('layouts.auth')

@section('content')
<div class="card admin">

    <div class="icon">🎓</div>

    <h2>Acceso Administrativo</h2>
    <p class="subtitle">Panel de control para personal administrativo</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="usuario@escuela.edu.mx" required autofocus>
        </div>

        <div class="input-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" placeholder="********" required>
        </div>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button class="btn btn-admin">
            Iniciar Sesión Administrativa
        </button>
    </form>

</div>
@endsection