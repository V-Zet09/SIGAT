@extends('layouts.master')

@section('title', 'Actividades Registradas')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .btn-square {
        width: 40px;
        height: 40px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        border-radius: 0.375rem;
    }
</style>
@endsection

@section('content')
<div class="shadow-2xl rounded-3xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-8 mx-auto mt-4 max-w-[80vw] transition-colors duration-300">

    <!-- Header visual tipo informes -->
    <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 dark:from-green-700 dark:via-emerald-700 dark:to-teal-700 p-6 shadow-xl">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-list-check text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Actividades Registradas</h1>
                    <p class="text-base text-green-100">Gestión y control institucional de actividades</p>
                </div>
            </div>
            <a href="{{ route('actividades.create') }}" class="group flex items-center space-x-2 rounded-lg bg-white px-6 py-3 text-base font-semibold text-green-600 shadow-lg transition hover:scale-105">
                <i class="fas fa-plus-circle text-lg transition group-hover:rotate-90"></i>
                <span>Nueva Actividad</span>
            </a>
        </div>
    </div>

    <!-- Buscador inteligente -->
    <div class="mb-6 bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
        <form method="GET" action="{{ route('actividades.registradas') }}" id="filtro-form" class="flex flex-wrap items-end gap-4 w-full">
            <!-- Año -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Año</label>
                <select name="filtro_anio" onchange="document.getElementById('filtro-form').submit()"
                    class="w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm outline-none">
                    <option value="">Todos los años</option>
                    @for ($y = now()->year; $y >= 2000; $y--)
                        <option value="{{ $y }}" {{ request('filtro_anio') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Mes -->
            <div class="flex-1 min-w-[180px]">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Mes</label>
<select name="filtro_mes" onchange="document.getElementById('filtro-form').submit()"
    class="w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm outline-none">
    <option value="">Todos los meses</option>
    <option value="1" {{ request('filtro_mes') == 1 ? 'selected' : '' }}>Enero</option>
    <option value="2" {{ request('filtro_mes') == 2 ? 'selected' : '' }}>Febrero</option>
    <option value="3" {{ request('filtro_mes') == 3 ? 'selected' : '' }}>Marzo</option>
    <option value="4" {{ request('filtro_mes') == 4 ? 'selected' : '' }}>Abril</option>
    <option value="5" {{ request('filtro_mes') == 5 ? 'selected' : '' }}>Mayo</option>
    <option value="6" {{ request('filtro_mes') == 6 ? 'selected' : '' }}>Junio</option>
    <option value="7" {{ request('filtro_mes') == 7 ? 'selected' : '' }}>Julio</option>
    <option value="8" {{ request('filtro_mes') == 8 ? 'selected' : '' }}>Agosto</option>
    <option value="9" {{ request('filtro_mes') == 9 ? 'selected' : '' }}>Septiembre</option>
    <option value="10" {{ request('filtro_mes') == 10 ? 'selected' : '' }}>Octubre</option>
    <option value="11" {{ request('filtro_mes') == 11 ? 'selected' : '' }}>Noviembre</option>
    <option value="12" {{ request('filtro_mes') == 12 ? 'selected' : '' }}>Diciembre</option>
</select>

            </div>

            <!-- Buscador Inteligente -->
            <div class="flex-1 min-w-[300px]">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    <i class="fas fa-search mr-1"></i>Buscar (área, autor, fecha, título...)
                </label>
                <input type="text" 
                    name="buscar" 
                    value="{{ request('buscar') }}"
                    placeholder="Ej: Agua potable, Darwin, 08/10/2025..."
                    class="w-full px-4 py-2 border-2 border-gray-800 dark:border-gray-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent">
            </div>

            <!-- Botón Buscar -->
            <div class="flex items-end">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition inline-flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    <span>Buscar</span>
                </button>
            </div>

            <!-- Limpiar -->
            <div class="flex items-end">
                <a href="{{ route('actividades.registradas') }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition inline-flex items-center gap-2">
                    <i class="fas fa-redo"></i>
                    <span>Limpiar</span>
                </a>
            </div>
        </form>
    </div>

    {{-- Tabla de Actividades --}}
    @if(isset($actividades) && $actividades->count())
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-gray-900 dark:text-gray-100">Título</th>
                            <th scope="col" class="px-6 py-3 text-gray-900 dark:text-gray-100">Autor</th>
                            <th scope="col" class="px-6 py-3 text-gray-900 dark:text-gray-100">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-gray-900 dark:text-gray-100">Área</th>
                            <th scope="col" class="px-6 py-3 text-center text-gray-900 dark:text-gray-100">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($actividades as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                    {{ $actividad->titulo }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $actividad->autor ?? 'Anónimo' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('actividades.show', $actividad->id) }}" 
                                            class="btn-square bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition" 
                                            title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('actividades.edit', $actividad->id) }}" 
                                            class="btn-square bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800 transition" 
                                            title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button"
                                                onclick="confirmarEliminacionActividad({{ $actividad->id }})"
                                                class="btn-square bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800 transition" 
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-row items-center justify-end">
                    {{ $actividades->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 rounded-lg p-6 text-center">
            <i class="fas fa-info-circle text-3xl mb-3"></i>
            <p class="text-lg font-medium">No se encontraron actividades</p>
            <p class="text-sm mt-1">Intenta ajustar los filtros de búsqueda</p>
        </div>
    @endif

    {{-- Modal y formulario de eliminar --}}
    <div id="modal-eliminar-actividad" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-300 text-xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                        ¿Eliminar actividad?
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Esta acción eliminará la actividad permanentemente. No se puede deshacer.
                    </p>
                </div>
                <div class="mt-6 flex gap-3 justify-end">
                    <button type="button" 
                            onclick="cerrarModalEliminar()"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        Cancelar
                    </button>
                    <button type="button" 
                            onclick="ejecutarEliminacion()"
                            class="px-4 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="form-eliminar-actividad" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
