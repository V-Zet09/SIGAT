@extends('layouts.master')

@section('title', 'Dashboard Regidor')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <div class="bg-gradient-to-r from-purple-600 to-violet-600 dark:from-purple-700 dark:to-violet-700 rounded-2xl shadow-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 p-1 shadow-lg">
                        @if(Auth::user()->avatar)
                           <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-purple-400 to-violet-500 flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'R', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <span class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full"></span>
                </div>

                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">
                        ¡Bienvenido, {{ Auth::user()->name ?? 'Regidor' }}!
                    </h1>
                    <p class="text-purple-100 dark:text-purple-200 flex items-center gap-2">
                        <i class="fas fa-user-tie text-yellow-300"></i>
                        <span class="font-medium">Regidor Municipal</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock text-purple-200"></i>
                        <span>{{ now()->format('d/m/Y - H:i') }}</span>
                    </p>
                </div>
            </div>

            <div class="hidden md:flex gap-3">
                <a href="{{ route('actividades.create') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus-circle"></i>
                    Nueva Actividad
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-2xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30 px-3 py-1 rounded-full">
                        TOTAL
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Total Actividades</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $totalActividades }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-purple-600 dark:text-purple-400 font-medium flex items-center gap-1">
                        <i class="fas fa-database text-xs"></i> En el sistema
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-1"></div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-violet-100 dark:bg-violet-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-check text-2xl text-violet-600 dark:text-violet-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-violet-600 dark:text-violet-400 bg-violet-100 dark:bg-violet-900/30 px-3 py-1 rounded-full">
                        PROPIAS
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Mis Actividades</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $misActividades }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-violet-600 dark:text-violet-400 font-medium flex items-center gap-1">
                        <i class="fas fa-pencil text-xs"></i> Registradas por mí
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-violet-500 to-violet-600 h-1"></div>
        </div>

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
                        <i class="fas fa-thumbs-up text-xs"></i> En el municipio
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-alt text-2xl text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 bg-cyan-100 dark:bg-cyan-900/30 px-3 py-1 rounded-full">
                        DOCS
                    </span>
                </div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Informes</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $totalInformes }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-cyan-600 dark:text-cyan-400 font-medium flex items-center gap-1">
                        <i class="fas fa-eye text-xs"></i> Para consulta
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 h-1"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                Acciones rápidas
            </h3>
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('actividades.create') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-plus-circle mr-2"></i>Registrar Nueva Actividad
                </a>
                <a href="{{ route('actividades.registradas') }}" class="bg-gradient-to-r from-violet-600 to-violet-700 hover:from-violet-700 hover:to-violet-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-list mr-2"></i>Ver Todas las Actividades
                </a>
                <a href="{{ route('informes-generados') }}" class="bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-file-alt mr-2"></i>Consultar Informes
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-pie mr-2 text-purple-600"></i>
                Mi Resumen de Actividades
            </h3>
            <ul class="space-y-3">
                <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-purple-50 to-purple-100/50 dark:from-purple-900/20 dark:to-purple-900/10 rounded-xl border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $misActividades }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Actividades registradas</p>
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
                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $misActividadesPendientes }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pendientes de aprobación</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                Actividades por Área Municipal
            </h3>
            <div id="chart-actividades-area" class="h-80"></div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-chart-line mr-2 text-violet-600"></i>
                Tendencia de Actividades (Últimos 6 meses)
            </h3>
            <div id="chart-tendencia-actividades" class="h-80"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-user-edit mr-2 text-purple-600 dark:text-purple-400"></i>Mis Últimas Actividades
            </h3>
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-3 py-2 overflow-x-auto border border-gray-200 dark:border-gray-800 max-h-96 custom-scrollbar">
                <table class="min-w-full text-xs">
                    <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900/50">
                        <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                            <th class="py-2 px-2 text-left">Título</th>
                            <th class="py-2 px-2 text-left">Área</th>
                            <th class="py-2 px-2 text-left">Estado</th>
                            <th class="py-2 px-2 text-center">Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($misActividadesLista as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                                <td class="py-2 px-2 text-gray-900 dark:text-gray-100">{{ Str::limit($actividad->titulo, 30) }}</td>
                                <td class="py-2 px-2">
                                    <span class="inline-block bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
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
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="text-purple-600 dark:text-purple-400 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                    <i class="fas fa-inbox text-2xl mb-2"></i>
                                    <p>Aún no has registrado actividades</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($misActividadesLista->isNotEmpty())
                <a href="{{ route('actividades.registradas') }}" class="text-sm font-semibold text-purple-600 dark:text-purple-400 hover:underline mt-3 block text-right">Ver todas mis actividades →</a>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-building mr-2 text-cyan-600 dark:text-cyan-400"></i>Actividades Recientes del Municipio
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
                        @forelse($actividadesRecientes as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                                <td class="py-2 px-2 text-gray-900 dark:text-gray-100">{{ Str::limit($actividad->titulo, 30) }}</td>
                                <td class="py-2 px-2">
                                    <span class="inline-block bg-cyan-100 dark:bg-cyan-900/40 text-cyan-800 dark:text-cyan-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2 text-center">
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="text-cyan-600 dark:text-cyan-400 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-4">Sin actividades recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($actividadesRecientes->isNotEmpty())
                <a href="{{ route('actividades.registradas') }}" class="text-sm font-semibold text-cyan-600 dark:text-cyan-400 hover:underline mt-3 block text-right">Ver todas →</a>
            @endif
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <i class="fas fa-file-invoice mr-2 text-cyan-600"></i>
            Informes Municipales Disponibles
        </h3>
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-alt text-3xl text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalInformes }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Informes disponibles para consulta</p>
                    </div>
                </div>
                <a href="{{ route('informes-generados') }}" class="bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-eye"></i>
                    Consultar Informes
                </a>
            </div>
        </div>
    </div>
</div>

<style>
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
        background: rgb(147 51 234);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgb(126 34 206);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
        colors: ['#9333ea'],
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

    const tendencia = @json($tendenciaActividades);
    const meses = Object.keys(tendencia);
    const valores = Object.values(tendencia);

    const optionsTendencia = {
        chart: {
            type: 'area',
            height: 320,
            toolbar: { show: false }
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
        colors: ['#8b5cf6'],
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
            enabled: false
        },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        }
    };

    const chartTendencia = new ApexCharts(document.querySelector("#chart-tendencia-actividades"), optionsTendencia);
    chartTendencia.render();
});
</script>
@endsection
