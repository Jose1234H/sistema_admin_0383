@extends('layouts.alumno')

@section('content')
<div class="portal-shell">
    @include('alumno.partials.sidebar')

    <main class="main-panel">
        <div class="page-title">
            <div>
                <h1>Hola, {{ $alumno->nombre }}!</h1>
                <p>Bienvenido a tu portal. Revisa tu inscripción, documentos y pagos en un solo lugar.</p>
            </div>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-label">Estado expediente</div>
                <strong>{{ $alumno->status_expediente }}</strong>
                <small>{{ $alumno->status_expediente == 'Completo' ? 'Tu expediente está completo.' : 'Faltan documentos por entregar.' }}</small>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pagos pendientes</div>
                <strong>
                    @php
                        $montoPendiente = 0;
                        if ($alumno->monto_inscripcion && $alumno->monto_inscripcion > $alumno->monto_pagado) {
                            $montoPendiente = $alumno->monto_inscripcion - $alumno->monto_pagado;
                        }
                    @endphp
                    @if($montoPendiente > 0)
                        ${{ number_format($montoPendiente, 2) }}
                    @else
                        $0.00
                    @endif
                </strong>
                <small>
                    @if($alumno->monto_inscripcion)
                        @if($montoPendiente > 0)
                            Monto pendiente de ${{ number_format($alumno->monto_inscripcion, 2) }}
                        @else
                            Has pagado ${{ number_format($alumno->monto_pagado ?? 0, 2) }} de ${{ number_format($alumno->monto_inscripcion, 2) }}
                        @endif
                    @else
                        Monto de inscripción no registrado
                    @endif
                </small>
            </div>
            <div class="stat-card">
                <div class="stat-label">Documentos pendientes</div>
                <strong>{{ $documentsPending }}</strong>
                <small>Documentos que aún debes entregar.</small>
            </div>
        </div>

        <div class="overview-grid">
            <section class="overview-card">
                <div class="section-header">
                    <h2>Actividad reciente</h2>
                </div>
                <div class="empty-state">Aún no hay actividad reciente.</div>
            </section>

            <section class="list-card">
                <div class="section-header">
                    <h2>Atajos rápidos</h2>
                </div>
                <table class="table-list">
                    <thead>
                        <tr>
                            <th>Sección</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Documentos</td>
                            <td><a href="{{ route('alumno.documentos') }}">Ver requisitos</a></td>
                        </tr>
                        <tr>
                            <td>Datos Biomédicos</td>
                            <td><a href="{{ route('alumno.datos-biomedicos') }}">Actualizar información</a></td>
                        </tr>
                        <tr>
                            <td>Inscripción</td>
                            <td><a href="{{ route('alumno.inscripciones') }}">Revisar estado</a></td>
                        </tr>
                        <tr>
                            <td>Pagos</td>
                            <td><a href="{{ route('alumno.pagos') }}">Ver recibos</a></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</div>
@endsection
