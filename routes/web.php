<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/admin/login', function () {
    return view('auth.admin-login');
});

Route::prefix('alumno')->controller(AlumnoController::class)->group(function () {
    Route::get('/login', 'welcome')->name('alumno.login');

    Route::get('/registro', 'showRegister')->name('alumno.register');
    Route::post('/registro', 'register')->name('alumno.register.submit');

    Route::get('/acceso', 'showAccess')->name('alumno.access');
    Route::post('/acceso', 'login')->name('alumno.access.submit');

    Route::post('/logout', 'logout')->name('alumno.logout');

    Route::get('/dashboard', 'dashboard')->name('alumno.dashboard');
    Route::get('/inscripciones', 'inscripciones')->name('alumno.inscripciones');
    Route::get('/documentos', 'documentos')->name('alumno.documentos');
    Route::post('/documentos/{documento}/upload', 'uploadDocumento')->name('alumno.documentos.upload');
    Route::get('/pagos', 'pagos')->name('alumno.pagos');
    Route::post('/pagos', 'storePago')->name('alumno.pagos.store');
    Route::get('/datos-biomedicos', 'datosBiomedicos')->name('alumno.datos-biomedicos');
    Route::put('/datos-biomedicos', 'updateDatosBiomedicos')->name('alumno.datos-biomedicos.update');
    Route::get('/perfil', 'perfil')->name('alumno.perfil');
});

Route::get('/inicio', [PaginaController::class, 'inicio']);
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/inscripciones', [AdminController::class, 'inscripciones'])->name('inscripciones');
    Route::get('/documentos', [AdminController::class, 'documentos'])->name('documentos');
    Route::get('/movimientos', [AdminController::class, 'movimientos'])->name('movimientos');
    Route::get('/pagos', [AdminController::class, 'pagos'])->name('pagos');
    
    Route::get('/alumnos/{id}', [AdminController::class, 'alumnoDetalle'])->name('admin.alumno-detalle');
    Route::get('/alumnos/{id}/editar', [AdminController::class, 'alumnoEditar'])->name('admin.alumno-editar');
    Route::put('/alumnos/{id}', [AdminController::class, 'alumnoActualizar'])->name('admin.alumno-actualizar');
    Route::get('/alumnos/{id}/ficha', [AdminController::class, 'alumnoFicha'])->name('admin.alumno-ficha');
    Route::post('/alumnos/{id}/observacion', [AdminController::class, 'alumnoObservacion'])->name('admin.alumno-observacion');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
