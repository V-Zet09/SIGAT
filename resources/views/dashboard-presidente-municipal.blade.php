@extends('layouts.master')

@section('title', 'Dashboard Presidente Municipal')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

    <!-- Header del Presidente Municipal - Verde Institucional -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-700 dark:to-teal-700 rounded-2xl shadow-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Avatar del Presidente -->
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 p-1 shadow-lg">
                        @if(Auth::user()->avatar)
                           <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <span class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full"></span>
                </div>
                
                <!-- Información del Presidente -->
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">
                        ¡Bienvenido, {{ Auth::user()->name ?? 'Presidente' }}!
                    </h1>
                    <p class="text-emerald-100 dark:text-emerald-200 flex items-center gap-2">
                        <i class="fas fa-landmark text-yellow-300"></i>
                        <span class="font-medium">Presidente Municipal</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock text-emerald-200"></i>
                        <span>{{ now()->format('d/m/Y - H:i') }}</span>
                    </p>
                </div>
            </div>
            
            <!-- Acceso rápido -->
            <div class="hidden md:flex gap-3">
                <a href="{{ route('informes-generados') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-file-invoice"></i>
                    Generar Informe
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
                    <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-2xl text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 rounded-full">
                        TOTAL
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Total Actividades</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $totalActividades }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                        <i class="fas fa-arrow-up text-xs"></i> {{ $actividadesMes }}
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">este mes</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-1"></div>
        </div>

        <!-- Pendientes de Revisión -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-2xl text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/30 px-3 py-1 rounded-full">
                        PENDIENTE
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Por Aprobar</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $actividadesPendientes }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-amber-600 dark:text-amber-400 font-medium flex items-center gap-1">
                        <i class="fas fa-exclamation-circle text-xs"></i> Requiere atención
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

        <!-- Informes Generados -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-invoice text-2xl text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 bg-cyan-100 dark:bg-cyan-900/30 px-3 py-1 rounded-full">
                        DOCS
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Informes</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $totalInformes }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-cyan-600 dark:text-cyan-400 font-medium flex items-center gap-1">
                        <i class="fas fa-download text-xs"></i> Generados
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">totales</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 h-1"></div>
        </div>
    </div>

    <!-- Sección principal: Acciones rápidas + Resumen -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Acciones rápidas -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                Acciones rápidas
            </h3>
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('actividades.registradas') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-list-check mr-2"></i>Ver Todas las Actividades
                </a>
                <a href="{{ route('actividades.create') }}" class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>Registrar Nueva Actividad
                </a>
                <a href="{{ route('informes-generados') }}" class="bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-file-invoice mr-2"></i>Generar Informe Municipal
                </a>
            </div>
        </div>
        
        <!-- Resumen de Áreas -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-pie mr-2 text-emerald-600"></i>
                Resumen por Estado
            </h3>
            <ul class="space-y-3">
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 rounded-xl border border-emerald-200 dark:border-emerald-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $actividadesAprobadas }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Actividades aprobadas</p>
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
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pendientes de aprobación</p>
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
                            <p class="text-sm text-gray-600 dark:text-gray-400">Actividades rechazadas</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Gráfica de Actividades por Área -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-emerald-600"></i>
                Actividades por Área
            </h3>
            <div id="chart-actividades-area" class="h-80"></div>
        </div>

        <!-- Gráfica de Tendencia Mensual -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-line mr-2 text-teal-600"></i>
                Tendencia Mensual
            </h3>
            <div id="chart-tendencia-mensual" class="h-80"></div>
        </div>
    </div>

    <!-- Tablas de Actividades -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Actividades Pendientes de Aprobación -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-exclamation-circle mr-2 text-amber-600 dark:text-amber-400"></i>Pendientes de Aprobación
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
                                    <span class="inline-block bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2 text-center">
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                    <i class="fas fa-check-circle text-2xl mb-2"></i>
                                    <p>No hay actividades pendientes</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($actividadesPendientesLista->isNotEmpty())
                <a href="{{ route('actividades.registradas') }}?estado=Pendiente" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:underline mt-3 block text-right">Ver todas →</a>
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

    <!-- Áreas sin Actividad -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <i class="fas fa-triangle-exclamation mr-2 text-red-600"></i>
            Áreas sin Actividad Reciente (últimos 30 días)
        </h3>
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-800">
            @if($areasSinActividad->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($areasSinActividad as $area)
                        <div class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $area }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Sin registro reciente</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-4xl text-green-500 mb-2"></i>
                    <p class="text-gray-600 dark:text-gray-400">Todas las áreas han registrado actividades</p>
                </div>
            @endif
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
        background: rgb(16 185 129);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgb(5 150 105);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===================================
    // GRÁFICA: Actividades por Área
    // ===================================
    const actividadesPorArea = @json($actividadesPorArea);
    const areas = Object.keys(actividadesPorArea);
    const cantidades = Object.values(actividadesPorArea);

    const optionsArea = {
        chart: {
            type: 'bar',
            height: 320,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                borderRadius: 6,
                dataLabels: {
                    position: 'top'
                }
            }
        },
        colors: ['#10b981'],
        series: [{
            name: 'Actividades',
            data: cantidades
        }],
        xaxis: {
            categories: areas,
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
            style: {
                colors: ['#fff']
            }
        },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
        }
    };

    const chartArea = new ApexCharts(document.querySelector("#chart-actividades-area"), optionsArea);
    chartArea.render();

    // ===================================
    // GRÁFICA: Tendencia Mensual
    // ===================================
    const tendenciaMensual = @json($tendenciaMensual);
    const meses = Object.keys(tendenciaMensual);
    const actividadesMes = Object.values(tendenciaMensual);

    const optionsTendencia = {
        chart: {
            type: 'area',
            height: 320,
            toolbar: { show: false },
            sparkline: { enabled: false }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2,
                stops: [0, 90, 100]
            }
        },
        colors: ['#14b8a6'],
        series: [{
            name: 'Actividades',
            data: actividadesMes
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
            enabled: false
        },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        }
    };

    const chartTendencia = new ApexCharts(document.querySelector("#chart-tendencia-mensual"), optionsTendencia);
    chartTendencia.render();
});
</script>
@endsection
