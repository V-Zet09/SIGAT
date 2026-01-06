@extends('layouts.master')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-700 dark:to-teal-700 rounded-2xl shadow-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-white dark:bg-gray-800 p-1 shadow-lg">
                        @if(Auth::user()->avatar)
                           <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <span class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full"></span>
                </div>

                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">
                        ¡Bienvenido, {{ Auth::user()->name ?? 'admin' }}!
                    </h1>
                    <p class="text-emerald-100 dark:text-emerald-200 flex items-center gap-2">
                        <i class="fas fa-crown text-yellow-300"></i>
                        <span class="font-medium">Administrador del Sistema</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-clock text-emerald-200"></i>
                        <span>{{ now()->format('d/m/Y - H:i') }}</span>
                    </p>
                </div>
            </div>

            <div class="hidden md:block">
                <a href="{{ route('usuarios.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-cog"></i>
                    Configuración
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
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
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">Actividades</h2>
                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $totalActividades }}</p>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                        <i class="fas fa-arrow-up text-xs"></i> +{{ $actividadesRevisadas }}
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">revisadas</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-1"></div>
        </div>

        <a href="{{ route('usuarios.index', ['estado' => 'conectado']) }}"
           class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden block">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-teal-100 dark:bg-teal-900/30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-2xl text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <span class="text-xs font-semibold text-teal-600 dark:text-teal-400 bg-teal-100 dark:bg-teal-900/30 px-3 py-1 rounded-full">
                        ACTIVOS
                    </span>
                </div>

                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">
                    Usuarios
                </h2>

                <p class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                    {{ $totalUsuarios ?? 0 }}
                </p>

                <div class="flex items-center gap-2 text-sm">
                    <span class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                        <i class="fas fa-check-circle text-xs"></i>
                        {{ $usuariosActivos ?? 0 }}
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">
                        conectados
                    </span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-1"></div>
        </a>

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
                    <span class="text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                        <i class="fas fa-download text-xs"></i> Generados
                    </span>
                    <span class="text-gray-500 dark:text-gray-400">este mes</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 h-1"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                    Acciones rápidas
                </h3>
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('actividades.create') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-plus-circle mr-2"></i>Registrar Actividad
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-users mr-2"></i>Ver Usuarios
                    </a>
                    <a href="{{ route('informes-generados') }}" class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white text-center py-4 text-base font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-file-invoice mr-2"></i>Generar Informe
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-emerald-600"></i>
                    Estado general
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 rounded-xl border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $actividadesRevisadas }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Actividades revisadas</p>
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
                                <p class="text-sm text-gray-600 dark:text-gray-400">Actividades pendientes</p>
                            </div>
                        </div>
                    </li>
                    <li class="flex items-center justify-between text-base p-4 bg-gradient-to-r from-teal-50 to-teal-100/50 dark:from-teal-900/20 dark:to-teal-900/10 rounded-xl border border-teal-200 dark:border-teal-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-check text-white"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $usuariosActivos }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Usuarios activos</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-calendar-days mr-2 text-emerald-600"></i>Calendario de Eventos
            </h3>

            <div id="calendar-container">
                <div class="flex items-center justify-between mb-4">
                    <button id="prev-month" class="p-2 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors" title="Mes anterior">
                        <i class="fas fa-chevron-left text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </button>

                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="calendar-month-year"></h4>

                    <button id="next-month" class="p-2 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors" title="Mes siguiente">
                        <i class="fas fa-chevron-right text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </button>
                </div>

                <div id="calendar-grid" class="grid grid-cols-7 gap-2 mb-4"></div>
            </div>

            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-3 gap-3">
                    <div class="flex flex-col items-center gap-2 p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-xs text-gray-600 dark:text-gray-400 text-center">Actividades</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 p-2 bg-teal-50 dark:bg-teal-900/20 rounded-lg">
                        <span class="w-3 h-3 rounded-full bg-teal-500"></span>
                        <span class="text-xs text-gray-600 dark:text-gray-400 text-center">Usuarios</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 p-2 bg-cyan-50 dark:bg-cyan-900/20 rounded-lg">
                        <span class="w-3 h-3 rounded-full bg-cyan-500"></span>
                        <span class="text-xs text-gray-600 dark:text-gray-400 text-center">Informes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border-2 border-emerald-200 dark:border-emerald-800 mb-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                <i class="fas fa-tasks mr-3 text-emerald-600 dark:text-emerald-400"></i>
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
                    @forelse($actividadesPendientesLista ?? [] as $actividad)
                        <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-colors">
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
                                    <button onclick="verDetalles({{ $actividad->id }})" class="text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 p-2 rounded-lg transition-colors" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    @if($actividad->estado !== 'Aprobada' && $actividad->estado !== 'Rechazada')
                                        <button onclick="abrirModalAprobar({{ $actividad->id }}, '{{ addslashes($actividad->titulo) }}')" class="text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40 p-2 rounded-lg transition-colors" title="Aprobar">
                                            <i class="fas fa-check"></i>
                                        </button>

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

    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-history text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Logs de Auditoría</h2>
                            <p class="text-purple-100 text-sm">Registro completo de actividades del sistema</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-white/20 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            <i class="fas fa-clock mr-1"></i> Tiempo real
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-200 dark:border-gray-700">
                <div class="p-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex gap-2 flex-wrap">
                        <button class="log-filter-btn active" data-filter="all">
                            <i class="fas fa-list-ul mr-1"></i> Todos
                        </button>
                        <button class="log-filter-btn" data-filter="login">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login/Logout
                        </button>
                        <button class="log-filter-btn" data-filter="crear">
                            <i class="fas fa-plus-circle mr-1"></i> Creaciones
                        </button>
                        <button class="log-filter-btn" data-filter="editar">
                            <i class="fas fa-edit mr-1"></i> Ediciones
                        </button>
                        <button class="log-filter-btn" data-filter="eliminar">
                            <i class="fas fa-trash mr-1"></i> Eliminaciones
                        </button>
                    </div>

                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input
                                type="text"
                                id="log-search"
                                placeholder="Buscar en logs..."
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div id="logs-container" class="space-y-3 max-h-[600px] overflow-y-auto custom-scrollbar">
                    @forelse($logs ?? [] as $log)
                        <div class="log-item"
                             data-action="{{ $log->action }}"
                             data-search="{{ strtolower($log->description . ' ' . $log->user_name) }}">

                            <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 border border-gray-200 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center
                                        @if($log->action === 'crear') bg-green-100 dark:bg-green-900/30
                                        @elseif($log->action === 'editar') bg-blue-100 dark:bg-blue-900/30
                                        @elseif($log->action === 'eliminar') bg-red-100 dark:bg-red-900/30
                                        @elseif($log->action === 'aprobar') bg-emerald-100 dark:bg-emerald-900/30
                                        @elseif($log->action === 'rechazar') bg-orange-100 dark:bg-orange-900/30
                                        @elseif($log->action === 'login') bg-cyan-100 dark:bg-cyan-900/30
                                        @elseif($log->action === 'logout') bg-gray-100 dark:bg-gray-900/30
                                        @elseif($log->action === 'ver') bg-purple-100 dark:bg-purple-900/30
                                        @elseif($log->action === 'descargar') bg-indigo-100 dark:bg-indigo-900/30
                                        @else bg-purple-100 dark:bg-purple-900/30
                                        @endif">
                                        <i class="fas {{ $log->icon }}
                                            @if($log->action === 'crear') text-green-600 dark:text-green-400
                                            @elseif($log->action === 'editar') text-blue-600 dark:text-blue-400
                                            @elseif($log->action === 'eliminar') text-red-600 dark:text-red-400
                                            @elseif($log->action === 'aprobar') text-emerald-600 dark:text-emerald-400
                                            @elseif($log->action === 'rechazar') text-orange-600 dark:text-orange-400
                                            @elseif($log->action === 'login') text-cyan-600 dark:text-cyan-400
                                            @elseif($log->action === 'logout') text-gray-600 dark:text-gray-400
                                            @elseif($log->action === 'ver') text-purple-600 dark:text-purple-400
                                            @elseif($log->action === 'descargar') text-indigo-600 dark:text-indigo-400
                                            @else text-purple-600 dark:text-purple-400
                                            @endif text-xl"></i>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $log->user_name ?? 'Sistema' }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                {{ $log->description }}
                                            </p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                                @if($log->action === 'crear') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                                @elseif($log->action === 'editar') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200
                                                @elseif($log->action === 'eliminar') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200
                                                @elseif($log->action === 'aprobar') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200
                                                @elseif($log->action === 'rechazar') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200
                                                @elseif($log->action === 'login') bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-200
                                                @elseif($log->action === 'logout') bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200
                                                @elseif($log->action === 'ver') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200
                                                @elseif($log->action === 'descargar') bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-200
                                                @else bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200
                                                @endif">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 dark:text-gray-400 flex-wrap">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-clock"></i>
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>
                                        @if($log->model_name)
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-tag"></i>
                                                {{ $log->model_name }}
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-network-wired"></i>
                                            {{ $log->ip_address }}
                                        </span>
                                        @if($log->method)
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-link"></i>
                                                {{ $log->method }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($log->old_values || $log->new_values)
                                        <button onclick="toggleDetails({{ $log->id }})" class="mt-2 text-xs text-purple-600 dark:text-purple-400 hover:underline flex items-center gap-1">
                                            <i class="fas fa-chevron-down transition-transform" id="icon-{{ $log->id }}"></i>
                                            Ver detalles
                                        </button>
                                        <div id="details-{{ $log->id }}" class="hidden mt-2 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-xs">
                                            @if($log->old_values)
                                                <div class="mb-2">
                                                    <strong class="text-gray-700 dark:text-gray-300">Valores anteriores:</strong>
                                                    <pre class="mt-1 text-gray-600 dark:text-gray-400 overflow-x-auto p-2 bg-gray-50 dark:bg-gray-900 rounded">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </div>
                                            @endif
                                            @if($log->new_values)
                                                <div>
                                                    <strong class="text-gray-700 dark:text-gray-300">Valores nuevos:</strong>
                                                    <pre class="mt-1 text-gray-600 dark:text-gray-400 overflow-x-auto p-2 bg-gray-50 dark:bg-gray-900 rounded">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400 text-lg font-semibold">No hay logs registrados</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Los registros de actividad aparecerán aquí</p>
                        </div>
                    @endforelse
                </div>

                @if(isset($logs) && $logs->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-list-check mr-2 text-emerald-600 dark:text-emerald-400"></i>Últimas Actividades
            </h3>
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-3 py-2 overflow-x-auto border border-gray-200 dark:border-gray-800">
                <table class="min-w-full text-xs">
                    <thead>
                        <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                            <th class="py-2 px-2 text-left">Título</th>
                            <th class="py-2 px-2 text-left">Autor</th>
                            <th class="py-2 px-2 text-left">Fecha</th>
                            <th class="py-2 px-2 text-left">Área</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($actividadesRecientes as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                                <td class="py-2 px-2 text-gray-900 dark:text-gray-100">{{ $actividad->titulo }}</td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ $actividad->autor ?? 'Anónimo' }}</td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                                <td class="py-2 px-2">
                                    <span class="inline-block bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-200 rounded-full px-2 py-0.5 text-xs font-medium">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('actividades.registradas') }}" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:underline mt-3 block text-right">Ver todas →</a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <i class="fas fa-user-group mr-2 text-teal-600 dark:text-teal-400"></i>Últimos Usuarios
            </h3>
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl px-3 py-2 overflow-x-auto border border-gray-200 dark:border-gray-800">
                <table class="min-w-full text-xs">
                    <thead>
                        <tr class="text-gray-700 dark:text-gray-300 border-b-2 border-gray-300 dark:border-gray-700 font-semibold">
                            <th class="py-2 px-2 text-left">Nombre</th>
                            <th class="py-2 px-2 text-left">Email</th>
                            <th class="py-2 px-2 text-left">Registrado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuariosRecientes as $usuario)
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800/70 transition-colors">
                                <td class="py-2 px-2 text-gray-900 dark:text-gray-100 font-medium">{{ $usuario->name }}</td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ $usuario->email }}</td>
                                <td class="py-2 px-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                        @if($usuariosRecientes->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 dark:text-gray-400 py-4">Sin registros</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <a href="{{ route('usuarios.index') }}" class="text-sm font-semibold text-teal-600 dark:text-teal-400 hover:underline mt-3 block text-right">Ver todos →</a>
            </div>
        </div>
    </div>
</div>

<style>
    .calendar-day {
        width: 40px;
        height: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        cursor: default;
        transition: all 0.2s;
    }

    .calendar-day:hover {
        transform: scale(1.08);
    }

    .log-filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
        background-color: rgb(243 244 246);
        color: rgb(55 65 81);
        border: 1px solid transparent;
    }

    .dark .log-filter-btn {
        background-color: rgb(55 65 81);
        color: rgb(209 213 219);
    }

    .log-filter-btn:hover {
        background-color: rgb(229 231 235);
        transform: scale(1.05);
    }

    .dark .log-filter-btn:hover {
        background-color: rgb(75 85 99);
    }

    .log-filter-btn.active {
        background: linear-gradient(to right, rgb(147 51 234), rgb(79 70 229));
        color: white;
        border-color: rgb(147 51 234);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }

    .log-item {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
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

<script>
let currentYear, currentMonth;
let allActividades = @json($fechasActividades);
let allUsuarios = @json($fechasUsuarios);
let allInformes = @json($fechasInformes);

document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    currentYear = now.getFullYear();
    currentMonth = now.getMonth();

    loadCalendarData(currentYear, currentMonth);

    document.getElementById('prev-month').addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        loadCalendarData(currentYear, currentMonth);
    });

    document.getElementById('next-month').addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        loadCalendarData(currentYear, currentMonth);
    });

    const filterButtons = document.querySelectorAll('.log-filter-btn');
    const logItems = document.querySelectorAll('.log-item');
    const searchInput = document.getElementById('log-search');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;

            logItems.forEach(item => {
                const action = item.dataset.action;
                const searchText = item.dataset.search;
                const searchValue = searchInput.value.toLowerCase();

                const matchesFilter = filter === 'all' || action === filter;
                const matchesSearch = searchValue === '' || searchText.includes(searchValue);

                if (matchesFilter && matchesSearch) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const activeFilter = document.querySelector('.log-filter-btn.active')?.dataset.filter || 'all';

            logItems.forEach(item => {
                const action = item.dataset.action;
                const searchText = item.dataset.search;

                const matchesFilter = activeFilter === 'all' || action === activeFilter;
                const matchesSearch = searchValue === '' || searchText.includes(searchValue);

                if (matchesFilter && matchesSearch) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});

function loadCalendarData(year, month) {
    fetch(`/api/calendario-eventos?year=${year}&month=${month + 1}`)
        .then(response => response.json())
        .then(data => {
            generateCalendar(year, month, data.actividades, data.usuarios, data.informes);
        })
        .catch(error => {
            generateCalendar(year, month, allActividades, allUsuarios, allInformes);
        });
}

function generateCalendar(year, month, actividades, usuarios, informes) {
    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const dayNames = ['D', 'L', 'M', 'X', 'J', 'V', 'S'];

    document.getElementById('calendar-month-year').textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const calendarGrid = document.getElementById('calendar-grid');
    calendarGrid.innerHTML = '';

    dayNames.forEach(dayName => {
        const dayHeader = document.createElement('div');
        dayHeader.className = 'text-center text-sm font-bold text-gray-600 dark:text-gray-400 py-2';
        dayHeader.textContent = dayName;
        calendarGrid.appendChild(dayHeader);
    });

    for (let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day';
        calendarGrid.appendChild(emptyDay);
    }

    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();

        const tieneActividad = actividades.includes(dateStr);
        const tieneUsuario = usuarios.includes(dateStr);
        const tieneInforme = informes.includes(dateStr);

        const dayCell = document.createElement('div');
        dayCell.className = `calendar-day ${
            isToday
                ? 'bg-emerald-500 text-white font-bold shadow-lg ring-2 ring-emerald-300'
                : 'bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
        }`;

        const dayNumber = document.createElement('span');
        dayNumber.className = 'text-sm font-semibold leading-none';
        dayNumber.textContent = day;
        dayCell.appendChild(dayNumber);

        if (tieneActividad || tieneUsuario || tieneInforme) {
            const dotsContainer = document.createElement('div');
            dotsContainer.className = 'flex gap-0.5 mt-1';

            if (tieneActividad) {
                const dotActividad = document.createElement('span');
                dotActividad.className = 'w-1.5 h-1.5 rounded-full bg-emerald-500';
                dotActividad.title = 'Actividad registrada';
                dotsContainer.appendChild(dotActividad);
            }

            if (tieneUsuario) {
                const dotUsuario = document.createElement('span');
                dotUsuario.className = 'w-1.5 h-1.5 rounded-full bg-teal-500';
                dotUsuario.title = 'Usuario creado';
                dotsContainer.appendChild(dotUsuario);
            }

            if (tieneInforme) {
                const dotInforme = document.createElement('span');
                dotInforme.className = 'w-1.5 h-1.5 rounded-full bg-cyan-500';
                dotInforme.title = 'Informe generado';
                dotsContainer.appendChild(dotInforme);
            }

            dayCell.appendChild(dotsContainer);
        }

        calendarGrid.appendChild(dayCell);
    }
}

function toggleDetails(id) {
    const details = document.getElementById(`details-${id}`);
    const icon = document.getElementById(`icon-${id}`);

    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        details.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

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
