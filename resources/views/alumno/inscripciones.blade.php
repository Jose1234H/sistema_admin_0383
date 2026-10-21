@extends('layouts.alumno')

@section('content')
<div class="portal-shell">
    @include('alumno.partials.sidebar')

    <main class="main-panel">
        <div class="page-title">
            <div>
                <h1>Inscripciones</h1>
                <p>Revisa tu información y el estado actual de tu trámite.</p>
            </div>
        </div>

        <div class="overview-grid">
            <section class="overview-card">
                <div class="section-header">
                    <h2>Datos de inscripción</h2>
                </div>
                <table class="table-list">
                    <tbody>
                        <tr>
                            <th>Matrícula</th>
                            <td>{{ $alumno->matricula }}</td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td>{{ $alumno->nombre }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</td>
                        </tr>
                        <tr>
                            <th>Grado y grupo</th>
                            <td>{{ $alumno->grado }} - {{ $alumno->grupo }}</td>
                        </tr>
                        <tr>
                            <th>Estado del expediente</th>
                            <td>{{ $alumno->status_expediente }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de inscripción</th>
                            <td>{{ optional($alumno->fecha_inscripcion)->format('d/m/Y') ?? 'No disponible' }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="list-card">
                <div class="section-header">
                    <h2>Documentos y pagos</h2>
                </div>
                <div class="empty-state">
                    Documentos pendientes: {{ $alumno->documentos()->where('status', 'Pendiente')->count() }}<br>
                    Pagos pendientes: {{ $alumno->pagos()->where('status', 'Pendiente')->count() }}
                </div>
            </section>
        </div>
    </main>
</div>
@endsection