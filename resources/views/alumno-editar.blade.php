<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno - Sistema de Gestión Administrativa</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-shell">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">🎓</div>
                <div>
                    <strong>Sec. 0383</strong>
                    <span>Vasco de Quiroga</span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="{{ url('/dashboard') }}" class="nav-link">
                    <span class="nav-icon">🏠</span>
                    Dashboard
                </a>
                <a href="{{ url('/inscripciones') }}" class="nav-link active">
                    <span class="nav-icon">📝</span>
                    Inscripciones
                </a>
                <a href="{{ url('/movimientos') }}" class="nav-link">
                    <span class="nav-icon">🔄</span>
                    Movimientos
                </a>
                <a href="{{ url('/pagos') }}" class="nav-link">
                    <span class="nav-icon">💰</span>
                    Pagos
                </a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">Cerrar Sesión</button>
            </form>
        </aside>

        <main class="main-content">
            <header class="page-header">
                <div>
                    <h1>Editar Alumno</h1>
                    <p>Matrícula: <strong>{{ $alumno->matricula }}</strong></p>
                </div>
            </header>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.alumno-actualizar', $alumno->id) }}" class="edit-form">
                @csrf
                @method('PUT')

                <section class="form-card">
                    <h2>Información Personal</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="{{ $alumno->nombre }}" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido_paterno">Apellido Paterno</label>
                            <input type="text" id="apellido_paterno" name="apellido_paterno" value="{{ $alumno->apellido_paterno }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" id="apellido_materno" name="apellido_materno" value="{{ $alumno->apellido_materno ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="curp">CURP</label>
                            <input type="text" id="curp" name="curp" value="{{ $alumno->curp }}" required maxlength="18">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $alumno->fecha_nacimiento?->format('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="genero">Género</label>
                            <select id="genero" name="genero">
                                <option value="">Seleccionar</option>
                                <option value="Masculino" {{ $alumno->genero === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ $alumno->genero === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" value="{{ $alumno->telefono ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ $alumno->email ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full">
                            <label for="direccion">Dirección</label>
                            <textarea id="direccion" name="direccion" rows="3">{{ $alumno->direccion ?? '' }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="form-card">
                    <h2>Información Académica</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="grado">Grado</label>
                            <select id="grado" name="grado" required>
                                <option value="">Seleccionar</option>
                                <option value="1ro" {{ $alumno->grado === '1ro' ? 'selected' : '' }}>1ro</option>
                                <option value="2do" {{ $alumno->grado === '2do' ? 'selected' : '' }}>2do</option>
                                <option value="3ro" {{ $alumno->grado === '3ro' ? 'selected' : '' }}>3ro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="grupo">Grupo</label>
                            <select id="grupo" name="grupo" required>
                                <option value="">Seleccionar</option>
                                <option value="A" {{ $alumno->grupo === 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ $alumno->grupo === 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ $alumno->grupo === 'C' ? 'selected' : '' }}>C</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="Activo" {{ $alumno->status === 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ $alumno->status === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_expediente">Status Expediente</label>
                            <select id="status_expediente" name="status_expediente" required>
                                <option value="Completo" {{ $alumno->status_expediente === 'Completo' ? 'selected' : '' }}>Completo</option>
                                <option value="Incompleto" {{ $alumno->status_expediente === 'Incompleto' ? 'selected' : '' }}>Incompleto</option>
                            </select>
                        </div>
                    </div>
                </section>

                <section class="form-card">
                    <h2>Información de Pago</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="monto_inscripcion">Monto de Inscripción</label>
                            <input type="number" id="monto_inscripcion" name="monto_inscripcion" value="{{ $alumno->monto_inscripcion ?? 0 }}" step="0.01" min="0" required>
                            <small>Monto total que debe pagar el alumno por inscripción</small>
                        </div>
                        <div class="form-group">
                            <label for="monto_pagado">Monto Pagado</label>
                            <input type="number" id="monto_pagado" name="monto_pagado" value="{{ $alumno->monto_pagado ?? 0 }}" step="0.01" min="0" required>
                            <small>Total que ha pagado hasta ahora</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full">
                            <label for="observaciones">Comentario administrativo</label>
                            <textarea id="observaciones" name="observaciones" rows="4">{{ old('observaciones', $alumno->observaciones) }}</textarea>
                            <small>Ej: Falta documentos, falta pago, expediente completo.</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full" style="background: #f8f9fa; padding: 10px; border-radius: 5px;">
                            <p style="margin: 0;">
                                <strong>Resumen del Pago:</strong><br>
                                Total a Pagar: <span id="totalAPagar">$0.00</span><br>
                                Total Pagado: <span id="totalPagado" style="color: #28a745;">$0.00</span><br>
                                <span id="faltante" style="color: #dc3545; font-weight: bold;">Pendiente: $0.00</span>
                            </p>
                        </div>
                    </div>
                </section>
                    <a href="{{ route('admin.alumno-detalle', $alumno->id) }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </main>
    </div>

    <style>
        .edit-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-card h2 {
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95em;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 0.95em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
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

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-group small {
            display: block;
            color: #666;
            font-size: 0.85em;
            margin-top: 5px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <script>
        function actualizarResumenPago() {
            const montoInscripcion = parseFloat(document.getElementById('monto_inscripcion').value) || 0;
            const montoPagado = parseFloat(document.getElementById('monto_pagado').value) || 0;
            const faltante = montoInscripcion - montoPagado;

            document.getElementById('totalAPagar').textContent = '$' + montoInscripcion.toFixed(2);
            document.getElementById('totalPagado').textContent = '$' + montoPagado.toFixed(2);
            
            const faltanteSpan = document.getElementById('faltante');
            if (faltante > 0) {
                faltanteSpan.style.color = '#dc3545';
                faltanteSpan.textContent = 'Pendiente: $' + faltante.toFixed(2);
            } else if (faltante === 0 && montoInscripcion > 0) {
                faltanteSpan.style.color = '#28a745';
                faltanteSpan.textContent = '✓ Pagado Completamente';
            } else {
                faltanteSpan.style.color = '#dc3545';
                faltanteSpan.textContent = 'Pendiente: $0.00';
            }
        }

        document.getElementById('monto_inscripcion').addEventListener('change', actualizarResumenPago);
        document.getElementById('monto_inscripcion').addEventListener('input', actualizarResumenPago);
        document.getElementById('monto_pagado').addEventListener('change', actualizarResumenPago);
        document.getElementById('monto_pagado').addEventListener('input', actualizarResumenPago);

        // Llamar al cargar la página
        document.addEventListener('DOMContentLoaded', actualizarResumenPago);
    </script>
</body>
</html>
