@extends('layouts.master')

@section('title', 'Detalle de Actividad')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <!-- Título -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            {{ $actividad->titulo }}
        </h2>

        <!-- Presupuesto -->
        <div class="flex items-center justify-between mb-4">
            <p class="text-xl font-bold text-green-600">
                ${{ number_format($actividad->presupuesto, 2) }}
            </p>
            <span class="text-sm text-gray-500">
                {{ $actividad->tipo_presupuesto }}
            </span>
        </div>

        <!--Información del autor y fecha -->
        <div class="flex flex-wrap gap-6 mb-6 text-gray-600">
            <div class="flex items-center gap-2">
                <i class="ri-user-line text-gray-500"></i>
                <span>{{ $actividad->autor ?? 'Anónimo' }}</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ri-calendar-line text-gray-500"></i>
                <span>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ri-briefcase-line text-gray-500"></i>
                <span>{{ $actividad->tipo_area }}</span>
            </div>
        </div>

        <!-- Resumen -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Resumen</h3>
            <p class="text-gray-600">{{ $actividad->resumen }}</p>
        </div>

        <!-- Contenido -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Contenido</h3>
            <div class="text-gray-600">
                {!! nl2br(e($actividad->contenido)) !!}
            </div>
        </div>

        <!-- Imagen centrada -->
        @if($actividad->foto)
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $actividad->foto) }}"
                     alt="Foto de actividad"
                     class="rounded-lg shadow max-h-96 object-contain">
            </div>
        @else
            <p class="text-center text-gray-500 italic mb-6">No hay imagen</p>
        @endif

        <!-- Botón volver -->
        <div class="text-center">
            <a href="{{ route('actividades.registradas') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
                ← Volver
            </a>
        </div>
    </div>
</div>
@endsection
