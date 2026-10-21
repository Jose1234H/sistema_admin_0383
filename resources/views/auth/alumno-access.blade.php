@extends('layouts.alumno')

@section('content')
<div class="student-login-page">
    <div class="login-card">
        <div class="login-left">
            <p>Ingreso al portal</p>
            <h1>Accede con tu matrícula</h1>
            <p>Usa tu matrícula y contraseña para entrar a tu espacio de alumno y revisar pagos, documentos e inscripción.</p>
            <div class="login-steps">
                <div class="step-item">
                    <span>1</span>
                    <div>
                        <strong>Ingresa tus datos</strong>
                        <span>Matricula y contraseña registrada.</span>
                    </div>
                </div>
                <div class="step-item">
                    <span>2</span>
                    <div>
                        <strong>Accede al portal</strong>
                        <span>Revisa tu estado de inscripción al instante.</span>
                    </div>
                </div>
                <div class="step-item">
                    <span>3</span>
                    <div>
                        <strong>Actualiza tu información</strong>
                        <span>Mantén tus datos al día desde tu perfil.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <form class="login-form" method="POST" action="{{ route('alumno.access.submit') }}">
                @csrf
                <h2>Ingresar</h2>

                @if(session('success'))
                    <div class="success-box">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="error-messages">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="input-group">
                    <label for="matricula">Matrícula</label>
                    <input id="matricula" name="matricula" type="text" value="{{ old('matricula') }}" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input id="password" name="password" type="password" required>
                </div>

                <button type="submit">Entrar</button>

                <div class="hint-box">
                    Si aún no registras tu inscripción, ve a "Registrar inscripción" para continuar.
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
