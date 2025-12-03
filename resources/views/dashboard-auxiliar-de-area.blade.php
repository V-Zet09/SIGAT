@extends('layouts.master')

@section('title', 'Dashboard Auxiliar de Área')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

    <!-- Header del Auxiliar de Área - Teal/Turquesa -->
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 dark:from-teal-700 dark:to-cyan-700 rounded-2xl shadow-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Avatar del Auxiliar -->
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 p-1 shadow-lg">
                        @if(Auth::user()->avatar)
                           <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <span class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full"></span>
                </div>
                
                <!-- Información del Auxiliar -->
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">
                        ¡Bienvenido, {{ Auth::user()->name ?? 'Auxiliar' }}!
                    </h1>
                    <p class="text-teal-100 dark:text-teal-200 flex items-center gap-2">
                        <i class="fas fa-user-cog text-yellow-300"></i>
                        <span class="font-medium">Auxiliar de Área</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-building text-teal-200"></i>
                        <span>{{ Auth::user()->departamento ?? 'Departamento' }}</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock text-teal-200"></i>
                        <span>{{ now()->format('d/m/Y - H:i') }}</span>
                    </p>
                </div>
            </div>
            
            <!-- Acceso rápido -->
            <div class="hidden md:flex gap-3">
                <a href="#" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus-circle"></i>
                    Registrar Actividad
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Mis Actividades Registradas -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-teal-100 dark:bg-teal-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-2xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-teal-600 dark:text-teal-400 bg-teal-100 dark:bg-teal-900/30 px-3 py-1 rounded-full">
                        PROPIAS
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Mis Actividades</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $misActividades }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-teal-600 dark:text-teal-400 font-medium flex items-center gap-1">
                        <i class="fas fa-pencil text-xs"></i> Registradas
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-1"></div>
        </div>

        <!-- Actividades del Área -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-tasks text-2xl text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 bg-cyan-100 dark:bg-cyan-900/30 px-3 py-1 rounded-full">
                        ÁREA
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Del Área</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $actividadesArea }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-cyan-600 dark:text-cyan-400 font-medium flex items-center gap-1">
                        <i class="fas fa-chart-line text-xs"></i> Total
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 h-1"></div>
        </div>

        <!-- Pendientes de Aprobación -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-2xl text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/30 px-3 py-1 rounded-full">
                        EN REVISIÓN
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">En Revisión</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $actividadesPendientes }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-amber-600 dark:text-amber-400 font-medium flex items-center gap-1">
                        <i class="fas fa-hourglass-half text-xs"></i> Esperando aprobación
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 h-1"></div>
        </div>

        <!-- Aprobadas -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-3 py-1 rounded-full">
                        APROBADO
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Aprobadas</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $misActividadesAprobadas }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                        <i class="fas fa-thumbs-up text-xs"></i> Completadas
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
        </div>
    </div>

    <!-- Sección principal: Acciones rápidas + Mis Tareas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Acciones rápidas -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                Acciones rápidas
            </h3>
            <div class="grid grid-cols-1 gap-3">
                <a href="#" class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>Registrar Nueva Actividad
                </a>
                <a href="#" class="bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-edit mr-2"></i>Editar Mis Actividades
                </a>
                <a href="#" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-list mr-2"></i>Ver Actividades del Área
                </a>
            </div>
        </div>
        
        <!-- Mis Tareas Recientes -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-clipboard-check mr-2 text-teal-600"></i>
                Mi Resumen de Trabajo
            </h3>
            <ul class="space-y-3">
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-teal-50 to-teal-100/50 dark:from-teal-900/20 dark:to-teal-900/10 rounded-xl border border-teal-200 dark:border-teal-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $misActividades }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Actividades registradas por mí</p>
                        </div>
                    </div>
                </li>
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-green-50 to-green-100/50 dark:from-green-900/20 dark:to-green-900/10 rounded-xl border border-green-200 dark:border-green-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $misActividadesAprobadas }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Mis actividades aprobadas</p>
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
                            <p class="text-sm text-gray-600 dark:text-gray-400">Esperando aprobación del Director</p>
                        </div>
                    </div>
                </li>
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-cyan-50 to-cyan-100/50 dark:from-cyan-900/20 dark:to-cyan-900/10 rounded-xl border border-cyan-200 dark:border-cyan-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-day text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $actividadesMes }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Registradas este mes</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TABLA: MIS ACTIVIDADES PARA EDITAR -->
    <!-- ============================================ -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                <i class="fas fa-edit mr-2 text-teal-600 dark:text-teal-400"></i>
                Mis Actividades - Gestión
            </h3>
        </div>
        
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-3 py-2 overflow-x-auto border border-gray-200 dark:border-gray-800 max-h-[500px] custom-scrollbar">
            <table class="min-w-full text-sm">
                <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900/50 z-10">
                    <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                        <th class="py-3 px-3 text-left">Título</th>
                        <th class="py-3 px-3 text-left">Área</th>
                        <th class="py-3 px-3 text-left">Fecha</th>
                        <th class="py-3 px-3 text-center">Estado</th>
                        <th class="py-3 px-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($misActividadesLista as $actividad)
                        <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                            <td class="py-3 px-3 text-gray-900 dark:text-gray-100 font-medium">
                                {{ Str::limit($actividad->titulo, 40) }}
                            </td>
                            <td class="py-3 px-3 text-gray-700 dark:text-gray-300">
                                <span class="text-xs bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 px-2 py-1 rounded-full">
                                    {{ $actividad->tipo_area ?? 'Sin área' }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-gray-700 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-3 text-center">
                                @if($actividad->estado === 'Aprobada')
                                    <span class="inline-block bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200 rounded-full px-3 py-1 text-xs font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Aprobada
                                    </span>
                                @elseif($actividad->estado === 'Rechazada')
                                    <span class="inline-block bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-200 rounded-full px-3 py-1 text-xs font-semibold">
                                        <i class="fas fa-times-circle mr-1"></i>Rechazada
                                    </span>
                                @else
                                    <span class="inline-block bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-200 rounded-full px-3 py-1 text-xs font-semibold">
                                        <i class="fas fa-clock mr-1"></i>En Revisión
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Ver detalles -->
                                    <a href="#" class="text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 p-2 rounded-lg transition-colors" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($actividad->estado === 'Pendiente' || $actividad->estado === 'Rechazada')
                                        <!-- Editar (solo si está pendiente o rechazada) -->
                                        <a href="#" class="text-teal-600 dark:text-teal-400 hover:bg-teal-100 dark:hover:bg-teal-900/40 p-2 rounded-lg transition-colors" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">Aprobada</span>
                                    @endif
                                    
                                    @if($actividad->estado === 'Rechazada')
                                        <!-- Ver motivo de rechazo -->
                                        <button onclick="verMotivoRechazo('{{ addslashes($actividad->motivo_rechazo ?? 'Sin motivo especificado') }}')" class="text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 p-2 rounded-lg transition-colors" title="Ver motivo de rechazo">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p class="text-lg">Aún no has registrado actividades</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gráfica y Actividades del Área -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Gráfica de Actividades por Mes -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-line mr-2 text-teal-600"></i>
                Mis Actividades (Últimos 6 meses)
            </h3>
            <div id="chart-mis-actividades" class="h-80"></div>
        </div>

        <!-- Actividades del Área (solo lectura) -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-building mr-2 text-cyan-600 dark:text-cyan-400"></i>Actividades del Área
            </h3>
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-3 py-2 overflow-x-auto border border-gray-200 dark:border-gray-800 max-h-96 custom-scrollbar">
                <table class="min-w-full text-xs">
                    <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900/50">
                        <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                            <th class="py-2 px-2 text-left">Título</th>
                            <th class="py-2 px-2 text-left">Creador</th>
                            <th class="py-2 px-2 text-left">Estado</th>
                            <th class="py-2 px-2 text-center">Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actividadesRecientesArea as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                                <td class="py-2 px-2 text-gray-900 dark:text-gray-100">{{ Str::limit($actividad->titulo, 30) }}</td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ $actividad->creador->name ?? 'N/A' }}</td>
                                <td class="py-2 px-2">
                                    @if($actividad->estado === 'Aprobada')
                                        <span class="inline-block bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                            Aprobada
                                        </span>
                                    @elseif($actividad->estado === 'Rechazada')
                                        <span class="inline-block bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                            Rechazada
                                        </span>
                                    @else
                                        <span class="inline-block bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 px-2 text-center">
                                    <a href="#" class="text-cyan-600 dark:text-cyan-400 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-4">Sin actividades recientes en el área</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL VER MOTIVO DE RECHAZO -->
<!-- ============================================ -->
<div id="modalMotivoRechazo" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                Motivo del Rechazo
            </h3>
            <button onclick="cerrarModalMotivo()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
            <p class="text-sm text-red-900 dark:text-red-100" id="motivoRechazoTexto"></p>
        </div>
        
        <button onclick="cerrarModalMotivo()" class="w-full bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white py-2 px-4 rounded-lg font-semibold transition-all duration-200">
            Entendido
        </button>
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
        background: rgb(20 184 166);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgb(13 148 136);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===================================
    // GRÁFICA: Mis Actividades por Mes
    // ===================================
    const misActividadesPorMes = @json($misActividadesPorMes);
    const meses = Object.keys(misActividadesPorMes);
    const valores = Object.values(misActividadesPorMes);

    const options = {
        chart: {
            type: 'bar',
            height: 320,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '60%',
                dataLabels: {
                    position: 'top'
                }
            }
        },
        colors: ['#14b8a6'],
        series: [{
            name: 'Actividades',
            data: valores
        }],
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
        dataLabels: {
            enabled: true,
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ['#14b8a6']
            }
        },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart-mis-actividades"), options);
    chart.render();
});

// ===================================
// FUNCIONES MODALES
// ===================================
function verMotivoRechazo(motivo) {
    document.getElementById('motivoRechazoTexto').textContent = motivo;
    document.getElementById('modalMotivoRechazo').classList.remove('hidden');
}

function cerrarModalMotivo() {
    document.getElementById('modalMotivoRechazo').classList.add('hidden');
}
</script>
@endsection
