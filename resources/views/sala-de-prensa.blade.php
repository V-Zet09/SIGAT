@extends('layouts.master-public')

@section('title', 'Sala de Prensa')

@section('css')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .card-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25);
    }
    
    .featured-badge {
        animation: pulse 2s infinite;
    }
    
    .image-overlay {
        transition: all 0.4s ease;
    }
    
    .card-hover:hover .image-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Principal --}}
        <div class="text-center mb-12 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg mb-4">
                <i class="ri-newspaper-line text-4xl text-white"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 mb-3">
                Sala de Prensa
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 font-medium">Últimas actividades y noticias del municipio</p>
            <div class="mt-4 flex items-center justify-center gap-2">
                <span class="h-1 w-12 bg-gradient-to-r from-blue-500 to-transparent rounded-full"></span>
                <i class="ri-flashlight-line text-2xl text-blue-500"></i>
                <span class="h-1 w-12 bg-gradient-to-l from-blue-500 to-transparent rounded-full"></span>
            </div>
        </div>

        @php
            // Verificar que la variable actividades exista y tenga contenido
            if (!isset($actividades)) {
                $actividades = \App\Models\Actividad::orderBy('fecha', 'desc')
                                                    ->orderBy('created_at', 'desc')
                                                    ->paginate(10);
            }
            
            // Obtener la actividad más reciente (principal)
            $actividadPrincipal = $actividades->first();
            // Obtener las demás actividades (secundarias)
            $actividadesSecundarias = $actividades->skip(1);
        @endphp

        @if($actividadPrincipal)
        {{-- Actividad Principal Destacada --}}
        <div class="mb-12 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="relative">
                {{-- Badge "Más Reciente" --}}
                <div class="absolute -top-4 left-8 z-10">
                    <span class="featured-badge inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white text-sm font-bold rounded-full shadow-lg">
                        <i class="ri-fire-line"></i>
                        MÁS RECIENTE
                    </span>
                </div>

                <div class="card-hover bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-700">
                    <div class="grid md:grid-cols-2 gap-0">
                        {{-- Imagen --}}
                        <div class="relative h-96 md:h-auto overflow-hidden">
                            @if($actividadPrincipal->foto)
                                <img src="{{ asset('storage/' . $actividadPrincipal->foto) }}" 
                                     alt="{{ $actividadPrincipal->titulo }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                    <i class="ri-image-line text-8xl text-white/30"></i>
                                </div>
                            @endif
                            <div class="image-overlay absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            
                            {{-- Badge de Área --}}
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-blue-600 text-xs font-bold rounded-full shadow-lg">
                                    {{ $actividadPrincipal->tipo_area ?? 'General' }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Contenido --}}
                        <div class="p-8 flex flex-col justify-between">
                            <div>
                                {{-- Fecha y Autor --}}
                                <div class="flex items-center gap-4 mb-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <i class="ri-calendar-line text-blue-500"></i>
                                        {{ \Carbon\Carbon::parse($actividadPrincipal->fecha)->format('d/m/Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="ri-user-line text-green-500"></i>
                                        {{ $actividadPrincipal->autor ?? 'Administrador' }}
                                    </span>
                                </div>

                                {{-- Título --}}
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4 leading-tight">
                                    {{ $actividadPrincipal->titulo }}
                                </h2>

                                {{-- Resumen --}}
                                <div class="text-gray-600 dark:text-gray-400 mb-6 line-clamp-4">
                                    {!! Str::limit(strip_tags($actividadPrincipal->resumen ?? $actividadPrincipal->contenido), 200) !!}
                                </div>
                            </div>

                            {{-- Botón --}}
                            <div class="flex items-center gap-3">
                                <a href="{{ route('actividades.show', $actividadPrincipal->id) }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105">
                                    <span>Leer más</span>
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                                
                                @if($actividadPrincipal->presupuesto)
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <i class="ri-money-dollar-circle-line text-green-500 text-lg"></i>
                                    <span class="font-semibold">${{ number_format($actividadPrincipal->presupuesto, 2) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Actividades Secundarias --}}
        @if($actividadesSecundarias->count() > 0)
        <div class="animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-3">
                    <i class="ri-news-line text-blue-600"></i>
                    Más Actividades
                </h2>
                <a href="{{ route('actividades.registradas') }}" 
                   class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium flex items-center gap-1">
                    Ver todas
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($actividadesSecundarias as $actividad)
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700">
                    {{-- Imagen --}}
                    <div class="relative h-48 overflow-hidden">
                        @if($actividad->foto)
                            <img src="{{ asset('storage/' . $actividad->foto) }}" 
                                 alt="{{ $actividad->titulo }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                                <i class="ri-image-line text-6xl text-white/30"></i>
                            </div>
                        @endif
                        <div class="image-overlay absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                        
                        {{-- Badge de Área --}}
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-blue-600 text-xs font-bold rounded-full shadow">
                                {{ $actividad->tipo_area ?? 'General' }}
                            </span>
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="p-5">
                        {{-- Fecha --}}
                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
                            <i class="ri-calendar-line text-blue-500"></i>
                            <span>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</span>
                            @if($actividad->autor)
                            <span class="mx-1">•</span>
                            <i class="ri-user-line text-green-500"></i>
                            <span>{{ $actividad->autor }}</span>
                            @endif
                        </div>

                        {{-- Título --}}
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 line-clamp-2 min-h-[3.5rem]">
                            {{ $actividad->titulo }}
                        </h3>

                        {{-- Resumen --}}
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                            {!! Str::limit(strip_tags($actividad->resumen ?? $actividad->contenido), 120) !!}
                        </p>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('actividades.show', $actividad->id) }}" 
                               class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:gap-2 transition-all text-sm font-medium">
                                <span>Leer más</span>
                                <i class="ri-arrow-right-line"></i>
                            </a>
                            
                            @if($actividad->presupuesto)
                            <div class="flex items-center gap-1 text-xs text-green-600 dark:text-green-400 font-semibold">
                                <i class="ri-money-dollar-circle-line"></i>
                                <span>${{ number_format($actividad->presupuesto, 0) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Estado Vacío --}}
        @if($actividades->count() === 0)
        <div class="text-center py-20 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-100 dark:bg-gray-800 mb-6">
                <i class="ri-newspaper-line text-5xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                No hay actividades publicadas
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Las actividades más recientes aparecerán aquí
            </p>
            <a href="{{ route('actividades.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition">
                <i class="ri-add-line"></i>
                <span>Publicar Actividad</span>
            </a>
        </div>
        @endif

        {{-- Paginación --}}
        @if($actividades->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg px-4 py-3">
                {{ $actividades->links() }}
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@section('script')
<script>
// Animaciones progresivas
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection