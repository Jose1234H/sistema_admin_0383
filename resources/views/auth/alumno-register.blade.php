@extends('layouts.alumno')

@section('content')
<div class="student-login-page">
    <div class="login-card">
        <div class="login-left">
            <p>Registro de inscripción</p>
            <h1>Completa tu inscripción</h1>
            <p>Llena todos los datos para generar tu matrícula y continuar hacia el portal de alumno.</p>
            <div class="login-steps">
                <div class="step-item">
                    <span>1</span>
                    <div>
                        <strong>Completa tus datos</strong>
                        <span>Registro personal, CURP, dirección y condiciones de pago.</span>
                    </div>
                </div>
                <div class="step-item">
                    <span>2</span>
                    <div>
                        <strong>Elige tu grupo</strong>
                        <span>Indica tu grado y grupo para asociar tu expediente al sistema.</span>
                    </div>
                </div>
                <div class="step-item">
                    <span>3</span>
                    <div>
                        <strong>Crea tu acceso</strong>
                        <span>Usarás tu matrícula y contraseña para ingresar al portal.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <form class="login-form" method="POST" action="{{ route('alumno.register.submit') }}">
                @csrf
                <h2>Registro</h2>

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

                <div class="input-grid">
                    <div class="input-group">
                        <label for="curp">CURP</label>
                        <input id="curp" name="curp" type="text" value="{{ old('curp') }}" required>
                    </div>
                </div>

                <div class="input-grid">
                    <div class="input-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="input-group">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input id="apellido_paterno" name="apellido_paterno" type="text" value="{{ old('apellido_paterno') }}" required>
                    </div>
                </div>

                <div class="input-grid">
                    <div class="input-group">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input id="apellido_materno" name="apellido_materno" type="text" value="{{ old('apellido_materno') }}">
                    </div>
                    <div class="input-group">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" value="{{ old('fecha_nacimiento') }}">
                    </div>
                </div>

                <div class="input-grid">
                    <div class="input-group">
                        <label for="genero">Género</label>
                        <select id="genero" name="genero">
                            <option value="">Selecciona</option>
                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" name="telefono" type="text" value="{{ old('telefono') }}">
                    </div>
                </div>

                <div class="input-group">
                    <label for="direccion">Dirección</label>
                    <textarea id="direccion" name="direccion">{{ old('direccion') }}</textarea>
                </div>

                <div class="input-grid">
                    <div class="input-group">
                        <label for="email">Correo electrónico</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}">
                    </div>
                    <div class="input-group">
                        <label for="grado">Grado</label>
                        <input id="grado" name="grado" type="text" value="{{ old('grado') }}">
                    </div>
                </div>

                <div class="input-grid">
                    <div class="input-group">
                        <label for="grupo">Grupo</label>
                        <input id="grupo" name="grupo" type="text" value="{{ old('grupo') }}">
                    </div>
                    <div class="input-group">
                        <label for="password">Contraseña</label>
                        <input id="password" name="password" type="password" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required>
                </div>

                <button type="submit">Guardar inscripción</button>

                <div class="hint-box">
                    Después de registrar tu inscripción, ingresa con tu matrícula y contraseña.
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
