@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">

    <div class="w-full max-w-md bg-white shadow-lg rounded-xl">

        <!-- Header -->
        <div class="space-y-4 text-center p-6 border-b">
            <div class="mx-auto w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center">
                <!-- Icono -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                </svg>
            </div>

            <div>
                <h2 class="text-2xl font-bold">Sistema de Gestión Administrativa</h2>
                <p class="mt-2 text-gray-500">
                    Secundaria Oficial No. 0383 "Vasco de Quiroga"
                </p>
            </div>
        </div>

        <!-- Form -->
        <div class="p-6">
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-400">
                            ✉️
                        </span>
                        <input 
                            type="email" 
                            name="email"
                            placeholder="usuario@escuela.edu.mx"
                            class="w-full pl-10 p-2 border rounded-md focus:ring-2 focus:ring-indigo-500"
                            required
                        >
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium">Contraseña</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-400">
                            🔒
                        </span>
                        <input 
                            type="password" 
                            name="password"
                            placeholder="••••••••"
                            class="w-full pl-10 p-2 border rounded-md focus:ring-2 focus:ring-indigo-500"
                            required
                        >
                    </div>
                </div>

                <!-- Button -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md">
                    Iniciar Sesión
                </button>

                <p class="text-sm text-center text-gray-500 mt-4">
                    Sistema protegido bajo normativas de resguardo de información
                </p>

            </form>
        </div>

    </div>
</div>
@endsection