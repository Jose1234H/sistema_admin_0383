@extends('layouts.alumno')

@section('content')
<div class="portal-shell">
    @include('alumno.partials.sidebar')

    <main class="main-panel">
        <div class="page-title">
            <div>
                <h1>Pagos</h1>
                <p>Revisa tu historial de pagos y registra nuevos pagos.</p>
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


        <div class="payment-grid">
            <section class="overview-card">
                <div class="section-header">
                    <h2>Registrar nuevo pago</h2>
                </div>
                <form method="POST" action="{{ route('alumno.pagos.store') }}" class="payment-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="concepto">Concepto de pago</label>
                            <input type="text" id="concepto" name="concepto" placeholder="Ej: Inscripción, Colegiatura" required>
                        </div>
                        <div class="form-group">
                            <label for="monto">Monto a pagar</label>
                            <input type="number" id="monto" name="monto" step="0.01" min="0" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="monto_pagado">Monto pagado</label>
                            <input type="number" id="monto_pagado" name="monto_pagado" step="0.01" min="0" placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label for="metodo_pago">Método de pago</label>
                            <select id="metodo_pago" name="metodo_pago" required>
                                <option value="">Seleccionar</option>
                                <option value="Efectivo">💵 Efectivo</option>
                                <option value="Tarjeta de credito">💳 Tarjeta de crédito</option>
                                <option value="Tarjeta de debito">💳 Tarjeta de débito</option>
                                <option value="Transferencia bancaria">🏦 Transferencia bancaria</option>
                                <option value="Deposito bancario">🏦 Depósito bancario</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="folio">Folio de referencia</label>
                            <input type="text" id="folio" name="folio" placeholder="Ej: N° de recibo, N° de transacción">
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha del pago</label>
                            <input type="date" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Registrar pago</button>
                    </div>
                </form>
            </section>

            <section class="overview-card">
                <div class="section-header">
                    <h2>Historial de pagos</h2>
                </div>
                <div class="payments-list">
                    @forelse($pagos as $pago)
                        <div class="payment-item">
                            <div class="payment-info">
                                <div class="payment-concept">
                                    <strong>{{ $pago->concepto }}</strong>
                                </div>
                                <div class="payment-details">
                                    <span class="payment-method">{{ $pago->metodo_pago }}</span>
                                    @if($pago->folio)
                                        <span class="payment-folio">Folio: {{ $pago->folio }}</span>
                                    @endif
                                    <span class="payment-date">{{ $pago->fecha->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <div class="payment-amounts">
                                <div class="amount-due">
                                    <small>Pendiente:</small>
                                    <strong>${{ number_format($pago->monto - ($pago->monto_pagado ?? 0), 2) }}</strong>
                                </div>
                                <div class="amount-paid">
                                    <small>Pagado:</small>
                                    <strong>${{ number_format($pago->monto_pagado ?? 0, 2) }}</strong>
                                </div>
                            </div>
                            <div class="payment-status">
                                <span class="badge badge-{{ strtolower(str_replace(' ', '-', $pago->status)) }}">
                                    {{ $pago->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <p>No hay pagos registrados aún.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </main>
</div>

<style>
    .payment-summary {
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .summary-card h3 {
        margin: 0 0 15px 0;
        color: #333;
        font-size: 1.2em;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
    }

    .summary-item .label {
        font-weight: 600;
        color: #666;
    }

    .summary-item .value {
        font-weight: 700;
        font-size: 1.1em;
    }

    .summary-item .value.paid {
        color: #28a745;
    }

    .summary-item .value.pending {
        color: #dc3545;
    }

    .summary-item .value.status {
        font-size: 1em;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .badge-paid {
        background: #d4edda;
        color: #155724;
    }

    .badge-partial {
        background: #fff3cd;
        color: #856404;
    }

    .badge-pending {
        background: #f8d7da;
        color: #721c24;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    @media (max-width: 1024px) {
        .payment-grid {
            grid-template-columns: 1fr;
        }
    }

    .payment-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 0.95em;
    }

    .form-group input,
    .form-group select {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 0.95em;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
    }

    .form-actions {
        margin-top: 10px;
    }

    .payments-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .payment-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        gap: 15px;
    }

    .payment-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .payment-info {
        flex: 1;
    }

    .payment-concept {
        margin-bottom: 8px;
        color: #333;
    }

    .payment-concept strong {
        font-size: 1.05em;
    }

    .payment-details {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 0.85em;
        color: #666;
    }

    .payment-method,
    .payment-folio,
    .payment-date {
        display: inline-block;
    }

    .payment-amounts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        text-align: center;
    }

    .amount-due,
    .amount-paid {
        display: flex;
        flex-direction: column;
    }

    .amount-due small,
    .amount-paid small {
        font-size: 0.8em;
        color: #999;
        margin-bottom: 3px;
    }

    .amount-due strong {
        color: #dc3545;
        font-size: 1.1em;
    }

    .amount-paid strong {
        color: #28a745;
        font-size: 1.1em;
    }

    .payment-status {
        min-width: 100px;
        text-align: center;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        display: inline-block;
    }

    .badge-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .badge-pagado {
        background: #d4edda;
        color: #155724;
    }

    .badge-parcial {
        background: #cce5ff;
        color: #004085;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-size: 0.95em;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
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

    .empty-state {
        text-align: center;
        padding: 30px;
        color: #999;
    }
</style>
@endsection