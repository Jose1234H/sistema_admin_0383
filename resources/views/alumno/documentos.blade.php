@extends('layouts.alumno')

@section('content')
<div class="portal-shell">
    @include('alumno.partials.sidebar')

    <main class="main-panel">
        <div class="page-title">
            <div>
                <h1>Documentos</h1>
                <p>Sube y revisa el estado de cada documento requerido para tu inscripción.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="overview-card">
            <div class="section-header">
                <h2>Lista de documentos</h2>
            </div>
            <div class="documents-container">
                @forelse($documentos as $documento)
                    <div class="document-card">
                        <div class="document-header">
                            <h3>{{ $documento->tipo }}</h3>
                            <span class="badge badge-{{ strtolower(str_replace(' ', '-', $documento->status)) }}">
                                {{ $documento->status }}
                            </span>
                        </div>
                        
                        @if($documento->archivo)
                            <div class="document-info">
                                <p><strong>Archivo:</strong> {{ basename($documento->archivo) }}</p>
                                <p><strong>Fecha de entrega:</strong> {{ $documento->fecha_entrega?->format('d/m/Y') ?? '-' }}</p>
                                <div class="document-actions">
                                    <a href="{{ asset('storage/' . $documento->archivo) }}" class="btn btn-sm btn-secondary" target="_blank">
                                        📥 Descargar
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="document-empty">No hay archivo cargado</p>
                        @endif

                        @if($documento->status === 'Pendiente')
                            <form action="{{ route('alumno.documentos.upload', $documento->id) }}" method="POST" enctype="multipart/form-data" class="document-form">
                                @csrf
                                <div class="form-group">
                                    <label for="archivo_{{ $documento->id }}">Seleccionar archivo</label>
                                    <input type="file" id="archivo_{{ $documento->id }}" name="archivo" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </div>
                                <button type="submit" class="btn btn-primary">Subir archivo</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <p>No hay documentos registrados.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>
</div>

<style>
    .documents-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .document-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        background: #f9f9f9;
        transition: all 0.3s ease;
    }

    .document-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .document-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .document-header h3 {
        margin: 0;
        color: #333;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .badge-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .badge-entregado {
        background: #d4edda;
        color: #155724;
    }

    .document-empty {
        color: #999;
        font-style: italic;
        margin: 10px 0;
    }

    .document-info {
        margin: 15px 0;
        padding: 10px;
        background: white;
        border-radius: 5px;
    }

    .document-info p {
        margin: 5px 0;
        font-size: 0.95em;
    }

    .document-actions {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }

    .document-form {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 0.95em;
    }

    .form-group input[type="file"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 0.9em;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-size: 0.9em;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #545b62;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 0.85em;
    }

    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }
</style>
@endsection