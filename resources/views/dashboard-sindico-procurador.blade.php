@extends('layouts.master')

@section('title', 'Dashboard Síndico Procurador')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

    <!-- Header del Síndico Procurador - Azul Institucional -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-700 dark:to-indigo-700 rounded-2xl shadow-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Avatar del Síndico -->
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 p-1 shadow-lg">
                        @if(Auth::user()->avatar)
                           <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <span class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full"></span>
                </div>
                
                <!-- Información del Síndico -->
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">
                        ¡Bienvenido, {{ Auth::user()->name ?? 'Síndico' }}!
                    </h1>
                    <p class="text-blue-100 dark:text-blue-200 flex items-center gap-2">
                        <i class="fas fa-balance-scale text-yellow-300"></i>
                        <span class="font-medium">Síndico Procurador</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock text-blue-200"></i>
                        <span>{{ now()->format('d/m/Y - H:i') }}</span>
                    </p>
                </div>
            </div>
            
            <!-- Acceso rápido -->
            <div class="hidden md:flex gap-3">
                <a href="{{ route('actividades.registradas') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-clipboard-check"></i>
                    Revisar Actividades
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Total Actividades -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-3 py-1 rounded-full">
                        TOTAL
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Total Actividades</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $totalActividades }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-blue-600 dark:text-blue-400 font-medium flex items-center gap-1">
                        <i class="fas fa-arrow-up text-xs"></i> {{ $actividadesMes }}
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">este mes</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-1"></div>
        </div>

        <!-- Por Aprobar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-gavel text-2xl text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/30 px-3 py-1 rounded-full">
                        PENDIENTE
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Por Aprobar</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $actividadesPendientes }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-amber-600 dark:text-amber-400 font-medium flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-xs"></i> Requiere revisión
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 h-1"></div>
        </div>

        <!-- Aprobadas por Síndico -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-double text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-3 py-1 rounded-full">
                        APROBADO
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Aprobadas</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $actividadesAprobadas }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                        <i class="fas fa-check text-xs"></i> {{ round(($actividadesAprobadas / max($totalActividades, 1)) * 100) }}%
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">del total</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
        </div>

        <!-- Rechazadas -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-times-circle text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30 px-3 py-1 rounded-full">
                        RECHAZADO
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Rechazadas</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $actividadesRechazadas }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-red-600 dark:text-red-400 font-medium flex items-center gap-1">
                        <i class="fas fa-ban text-xs"></i> Observaciones
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">legales</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-red-600 h-1"></div>
        </div>
    </div>
    <!-- ============================================ -->
    <!-- SECCIÓN: GESTIÓN DE ACTIVIDADES (SÍNDICO) -->
    <!-- ============================================ -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border-2 border-blue-200 dark:border-blue-800 mb-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                <i class="fas fa-gavel mr-3 text-blue-600 dark:text-blue-400"></i>
                Gestión de Actividades del Sistema
            </h3>
            @if(($actividadesPendientes ?? 0) > 0)
                <span class="bg-yellow-500 text-white text-sm font-bold px-4 py-2 rounded-full animate-pulse flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $actividadesPendientes }} Por Revisar
                </span>
            @endif
        </div>
        
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-4 py-3 overflow-x-auto border border-gray-200 dark:border-gray-800 max-h-[600px] custom-scrollbar">
            <table class="min-w-full text-sm">
                <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900/50 z-10">
                    <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                        <th class="py-3 px-4 text-left">Área</th>
                        <th class="py-3 px-4 text-left">Título</th>
                        <th class="py-3 px-4 text-left">Tipo</th>
                        <th class="py-3 px-4 text-left">Creador</th>
                        <th class="py-3 px-4 text-left">Fecha</th>
                        <th class="py-3 px-4 text-center">Estado</th>
                        <th class="py-3 px-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($actividadesGestionLista ?? [] as $actividad)
                        <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                            <td class="py-3 px-4 text-gray-900 dark:text-gray-100">
                                <span class="text-xs bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 px-2 py-1 rounded-full font-semibold">
                                    {{ $actividad->tipo_area ?? 'Sin área' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-900 dark:text-gray-100 font-medium">
                                {{ Str::limit($actividad->titulo, 45) }}
                            </td>
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                <span class="text-xs bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">
                                    {{ $actividad->tipo_actividad ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user-circle text-gray-400"></i>
                                    {{ $actividad->creador->name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($actividad->estado === 'Aprobada')
                                    <span class="inline-flex items-center gap-1 bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200 rounded-full px-3 py-1 text-xs font-semibold">
                                        <i class="fas fa-check-circle"></i>Aprobada
                                    </span>
                                @elseif($actividad->estado === 'Rechazada')
                                    <span class="inline-flex items-center gap-1 bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-200 rounded-full px-3 py-1 text-xs font-semibold">
                                        <i class="fas fa-times-circle"></i>Rechazada
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-200 rounded-full px-3 py-1 text-xs font-semibold">
                                        <i class="fas fa-clock"></i>Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Ver detalles -->
                                    <button onclick="verDetalles({{ $actividad->id }})" class="text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 p-2 rounded-lg transition-colors" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    @if($actividad->estado !== 'Aprobada' && $actividad->estado !== 'Rechazada')
                                        <!-- Aprobar -->
                                        <button onclick="abrirModalAprobar({{ $actividad->id }}, '{{ addslashes($actividad->titulo) }}')" class="text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40 p-2 rounded-lg transition-colors" title="Aprobar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        
                                        <!-- Rechazar -->
                                        <button onclick="abrirModalRechazar({{ $actividad->id }}, '{{ addslashes($actividad->titulo) }}')" class="text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 p-2 rounded-lg transition-colors" title="Rechazar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">
                                            @if($actividad->estado === 'Aprobada')
                                                <i class="fas fa-check text-green-500"></i> Procesada
                                            @else
                                                <i class="fas fa-times text-red-500"></i> Procesada
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 dark:text-gray-400 py-10">
                                <i class="fas fa-check-circle text-5xl mb-3 text-green-500"></i>
                                <p class="text-lg font-semibold">¡Excelente trabajo!</p>
                                <p class="text-sm">No hay actividades pendientes de gestión</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODALES PARA APROBAR/RECHAZAR -->
    <div id="modalAprobar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                    Aprobar Actividad
                </h3>
                <button onclick="cerrarModalAprobar()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                ¿Estás seguro de aprobar la siguiente actividad?
            </p>
            
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
                <p class="text-sm font-semibold text-green-900 dark:text-green-100" id="tituloActividadAprobar"></p>
            </div>
            
            <form id="formAprobar" method="POST" action="">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Observaciones (opcional)
                    </label>
                    <textarea name="observaciones" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-gray-100" placeholder="Comentarios adicionales..."></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="cerrarModalAprobar()" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i>
                        Aprobar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalRechazar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                    <i class="fas fa-times-circle text-red-600 mr-2"></i>
                    Rechazar Actividad
                </h3>
                <button onclick="cerrarModalRechazar()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                ¿Estás seguro de rechazar la siguiente actividad?
            </p>
            
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                <p class="text-sm font-semibold text-red-900 dark:text-red-100" id="tituloActividadRechazar"></p>
            </div>
            
            <form id="formRechazar" method="POST" action="">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Motivo del rechazo <span class="text-red-500">*</span>
                    </label>
                    <textarea name="motivo_rechazo" rows="4" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-gray-100" placeholder="Explica por qué rechazas esta actividad..."></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="cerrarModalRechazar()" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Rechazar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sección principal: Acciones rápidas + Resumen de Revisión -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Acciones rápidas -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                Acciones rápidas
            </h3>
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('actividades.registradas') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-clipboard-check mr-2"></i>Revisar Actividades
                </a>
                <a href="{{ route('actividades.create') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>Registrar Actividad
                </a>
                <a href="{{ route('informes-generados') }}" class="bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-file-invoice mr-2"></i>Ver Informes
                </a>
            </div>
        </div>
        
        <!-- Resumen de Revisión Legal -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-scale-balanced mr-2 text-blue-600"></i>
                Resumen de Revisión Legal
            </h3>
            <ul class="space-y-3">
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-green-50 to-green-100/50 dark:from-green-900/20 dark:to-green-900/10 rounded-xl border border-green-200 dark:border-green-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $actividadesAprobadas }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Aprobadas legalmente</p>
                        </div>
                    </div>
                </li>
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10 rounded-xl border border-amber-200 dark:border-amber-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $actividadesPendientes }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pendientes de revisión</p>
                        </div>
                    </div>
                </li>
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-red-50 to-red-100/50 dark:from-red-900/20 dark:to-red-900/10 rounded-xl border border-red-200 dark:border-red-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $actividadesRechazadas }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Con observaciones legales</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Gráfica de Aprobaciones por Área -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-pie mr-2 text-blue-600"></i>
                Aprobaciones por Área
            </h3>
            <div id="chart-aprobaciones-area" class="h-80"></div>
        </div>

        <!-- Gráfica de Tendencia de Revisiones -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-line mr-2 text-indigo-600"></i>
                Tendencia de Revisiones Mensuales
            </h3>
            <div id="chart-tendencia-revisiones" class="h-80"></div>
        </div>
    </div>

    <!-- Tablas de Actividades -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Actividades Pendientes de Revisión -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-gavel mr-2 text-amber-600 dark:text-amber-400"></i>Pendientes de Revisión Legal
            </h3>
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-3 py-2 overflow-x-auto border border-gray-200 dark:border-gray-800 max-h-96 custom-scrollbar">
                <table class="min-w-full text-xs">
                    <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900/50">
                        <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                            <th class="py-2 px-2 text-left">Título</th>
                            <th class="py-2 px-2 text-left">Área</th>
                            <th class="py-2 px-2 text-left">Fecha</th>
                            <th class="py-2 px-2 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actividadesPendientesLista as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                                <td class="py-2 px-2 text-gray-900 dark:text-gray-100">{{ Str::limit($actividad->titulo, 30) }}</td>
                                <td class="py-2 px-2">
                                    <span class="inline-block bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2 text-center">
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                    <i class="fas fa-check-circle text-2xl mb-2"></i>
                                    <p>No hay actividades pendientes de revisión</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($actividadesPendientesLista->isNotEmpty())
                <a href="{{ route('actividades.registradas') }}?estado=Pendiente" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline mt-3 block text-right">Ver todas →</a>
            @endif
        </div>

        <!-- Últimas Actividades Aprobadas -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-600 dark:text-green-400"></i>Últimas Aprobadas
            </h3>
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-3 py-2 overflow-x-auto border border-gray-200 dark:border-gray-800 max-h-96 custom-scrollbar">
                <table class="min-w-full text-xs">
                    <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900/50">
                        <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                            <th class="py-2 px-2 text-left">Título</th>
                            <th class="py-2 px-2 text-left">Área</th>
                            <th class="py-2 px-2 text-left">Fecha</th>
                            <th class="py-2 px-2 text-center">Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actividadesAprobadasLista as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                                <td class="py-2 px-2 text-gray-900 dark:text-gray-100">{{ Str::limit($actividad->titulo, 30) }}</td>
                                <td class="py-2 px-2">
                                    <span class="inline-block bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2 text-center">
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="text-green-600 dark:text-green-400 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-4">Sin actividades aprobadas aún</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($actividadesAprobadasLista->isNotEmpty())
                <a href="{{ route('actividades.registradas') }}?estado=Aprobada" class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline mt-3 block text-right">Ver todas →</a>
            @endif
        </div>
    </div>

    <!-- Informes Generados -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <i class="fas fa-file-alt mr-2 text-cyan-600"></i>
            Informes Municipales Generados
        </h3>
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-invoice text-3xl text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalInformes }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Informes totales generados</p>
                    </div>
                </div>
                <a href="{{ route('informes-generados') }}" class="bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-eye"></i>
                    Ver Informes
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Scrollbar personalizado */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgb(243 244 246);
        border-radius: 10px;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-track {
        background: rgb(31 41 55);
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgb(37 99 235);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgb(29 78 216);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===================================
    // GRÁFICA: Aprobaciones por Área
    // ===================================
    const aprobacionesPorArea = @json($aprobacionesPorArea);
    const areas = Object.keys(aprobacionesPorArea);
    const cantidades = Object.values(aprobacionesPorArea);

    const optionsArea = {
        chart: {
            type: 'donut',
            height: 320
        },
        series: cantidades,
        labels: areas,
        colors: ['#3b82f6', '#6366f1', '#8b5cf6', '#a855f7', '#ec4899', '#f43f5e', '#ef4444', '#f97316', '#f59e0b', '#eab308'],
        legend: {
            position: 'bottom',
            labels: {
                colors: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val.toFixed(0) + '%';
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                        }
                    }
                }
            }
        }
    };

    const chartArea = new ApexCharts(document.querySelector("#chart-aprobaciones-area"), optionsArea);
    chartArea.render();

    // ===================================
    // GRÁFICA: Tendencia de Revisiones
    // ===================================
    const tendenciaRevisiones = @json($tendenciaRevisiones);
    const meses = Object.keys(tendenciaRevisiones);
    const aprobadas = meses.map(mes => tendenciaRevisiones[mes].aprobadas || 0);
    const rechazadas = meses.map(mes => tendenciaRevisiones[mes].rechazadas || 0);
    const pendientes = meses.map(mes => tendenciaRevisiones[mes].pendientes || 0);

    const optionsTendencia = {
        chart: {
            type: 'line',
            height: 320,
            toolbar: { show: false }
        },
        series: [
            {
                name: 'Aprobadas',
                data: aprobadas,
                color: '#10b981'
            },
            {
                name: 'Rechazadas',
                data: rechazadas,
                color: '#ef4444'
            },
            {
                name: 'Pendientes',
                data: pendientes,
                color: '#f59e0b'
            }
        ],
        xaxis: {
            categories: meses,
            labels: {
                style: {
                    colors: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                }
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        markers: {
            size: 5
        },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
        },
        legend: {
            position: 'top',
            labels: {
                colors: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
            }
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        }
    };

    const chartTendencia = new ApexCharts(document.querySelector("#chart-tendencia-revisiones"), optionsTendencia);
    chartTendencia.render();
});
// FUNCIONES PARA MODALES DE APROBAR/RECHAZAR
function abrirModalAprobar(id, titulo) {
    document.getElementById('tituloActividadAprobar').textContent = titulo;
    document.getElementById('formAprobar').action = `/actividades/${id}/aprobar`;
    document.getElementById('modalAprobar').classList.remove('hidden');
}

function cerrarModalAprobar() {
    document.getElementById('modalAprobar').classList.add('hidden');
}

function abrirModalRechazar(id, titulo) {
    document.getElementById('tituloActividadRechazar').textContent = titulo;
    document.getElementById('formRechazar').action = `/actividades/${id}/rechazar`;
    document.getElementById('modalRechazar').classList.remove('hidden');
}

function cerrarModalRechazar() {
    document.getElementById('modalRechazar').classList.add('hidden');
}

function verDetalles(id) {
    window.location.href = `/actividades/${id}`;
}

</script>
@endsection
