@extends('layouts.master')

@section('title', 'Detalle de Actividad')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <!-- Título -->
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            {{ $actividad->titulo }}
        </h2>

        <!-- Presupuesto -->
        @if($actividad->presupuesto)
        <div class="flex items-center justify-between mb-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
            <p class="text-xl font-bold text-green-600 dark:text-green-400">
                ${{ number_format($actividad->presupuesto, 2) }}
            </p>
            @if($actividad->tipo_presupuesto)
            <span class="px-3 py-1 text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 rounded-full">
                {{ $actividad->tipo_presupuesto }}
            </span>
            @endif
        </div>
        @endif

        <!-- Información del autor y fecha -->
        <div class="flex flex-wrap gap-6 mb-6 text-gray-600 dark:text-gray-400">
            <div class="flex items-center gap-2">
                <i class="ri-user-line text-blue-500 dark:text-blue-400"></i>
                <span>{{ $actividad->autor ?? 'Anónimo' }}</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ri-calendar-line text-purple-500 dark:text-purple-400"></i>
                <span>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</span>
            </div>
            @if($actividad->tipo_area)
            <div class="flex items-center gap-2">
                <i class="ri-briefcase-line text-orange-500 dark:text-orange-400"></i>
                <span>{{ $actividad->tipo_area }}</span>
            </div>
            @endif
        </div>

        <!-- Resumen -->
        @if($actividad->resumen)
        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                <i class="ri-file-text-line text-blue-500"></i>
                Resumen
            </h3>
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                {!! $actividad->resumen !!}
            </div>
        </div>
        @endif

        <!-- Contenido -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                <i class="ri-article-line text-green-500"></i>
                Contenido
            </h3>
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed prose dark:prose-invert max-w-none">
                {!! $actividad->contenido !!}
            </div>
        </div>

        <!-- Galería de Fotos -->
        @php
            // Obtener las fotos y asegurarse de que sea un array
            $fotos = $actividad->fotos;
            if (is_string($fotos)) {
                $fotos = json_decode($fotos, true) ?? [];
            } elseif (!is_array($fotos)) {
                $fotos = [];
            }
        @endphp

        @if(!empty($fotos) && count($fotos) > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                    <i class="ri-gallery-line text-purple-500"></i>
                    Galería de Fotos ({{ count($fotos) }})
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($fotos as $index => $foto)
                        @if(!empty($foto))
                            <div class="relative group rounded-lg overflow-hidden shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 transition-all duration-300">
                                <img src="{{ asset('storage/' . ltrim($foto, '/')) }}"
                                     alt="{{ $actividad->titulo }} - Foto {{ $index + 1 }}"
                                     class="w-full h-64 object-cover bg-gray-100 dark:bg-gray-900 group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                                    <p class="text-white text-xs font-medium">Foto {{ $index + 1 }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <div class="flex justify-center mb-6 p-8 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                <div class="text-center">
                    <i class="ri-image-line text-5xl text-gray-400 dark:text-gray-500 mb-2"></i>
                    <p class="text-gray-500 dark:text-gray-400 italic">No hay fotos disponibles</p>
                </div>
            </div>
        @endif

        <!-- Botones de acción -->
        <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('actividades.registradas') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-700 dark:bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-500 transition shadow-md hover:shadow-lg">
                <i class="ri-arrow-left-line"></i>
                <span>Volver</span>
            </a>

            <div class="flex gap-2">
                <a href="{{ route('actividades.edit', $actividad->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                    <i class="ri-edit-line"></i>
                    <span>Editar</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
