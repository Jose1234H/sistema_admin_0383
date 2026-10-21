@extends('layouts.alumno')

@section('content')
<div class="portal-shell">
    @include('alumno.partials.sidebar')

    <main class="main-panel">
        <div class="page-title">
            <div>
                <h1>Datos Biomédicos</h1>
                <p>Registra y revisa tus datos biomédicos para completar tu expediente.</p>
            </div>
        </div>

        <section class="overview-card">
            <div class="section-header">
                <h2>Información Biomédica</h2>
            </div>
            <form method="POST" action="{{ route('alumno.datos-biomedicos.update') }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="tipo_sangre">Tipo de Sangre</label>
                    <select name="tipo_sangre" id="tipo_sangre">
                        <option value="">Seleccionar</option>
                        <option value="A+" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ ($datosBiomedicos->tipo_sangre ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estatura">Estatura (cm)</label>
                    <input type="number" step="0.01" name="estatura" id="estatura" value="{{ $datosBiomedicos->estatura ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="peso">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" id="peso" value="{{ $datosBiomedicos->peso ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="numero_seguro">Número de Seguro</label>
                    <input type="text" name="numero_seguro" id="numero_seguro" value="{{ $datosBiomedicos->numero_seguro ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="alergias">Alergias</label>
                    <textarea name="alergias" id="alergias">{{ $datosBiomedicos->alergias ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="contacto_emergencia">Contacto de Emergencia</label>
                    <input type="text" name="contacto_emergencia" id="contacto_emergencia" value="{{ $datosBiomedicos->contacto_emergencia ?? '' }}">
                </div>
                <button type="submit" class="btn-primary">Guardar</button>
            </form>
        </section>
    </main>
</div>
@endsection