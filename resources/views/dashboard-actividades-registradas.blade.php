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
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">
            📋 Registro General de Actividades
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Actividades registradas en el sistema</p>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filtros y Buscador --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('actividades.registradas') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4">
            {{-- Buscador --}}
            <div class="md:col-span-4">
                <div class="relative">
                    <input type="text" 
                           name="buscar" 
                           class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent" 
                           placeholder="Buscar actividad..." 
                           value="{{ request('buscar') }}">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-gray-500"></i>
                </div>
            </div>

            {{-- Filtro por Área --}}
            <div class="md:col-span-4">
                <select name="tipo_area" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent">
                    <option value="">Todas las áreas</option>
                    @foreach([
                        'Agua potable',
                        'Bienestar Social y Desarrollo Rural',
                        'Catastro',
                        'Contraloria Interna',
                        'Deportes',
                        'DIF',
                        'Informática',
                        'Limpia',
                        'Obras Publicas',
                        'Oficialia Mayor',
                        'Presidencia',
                        'Recursos Humanos',
                        'Registro Civil',
                        'Regidores',
                        'Reglamentos',
                        'Secretaria General',
                        'Seguridad Publica',
                        'Sindicatura',
                        'Tesoreria',
                        'Transito'
                    ] as $opcion)
                        <option value="{{ $opcion }}" {{ request('tipo_area') == $opcion ? 'selected' : '' }}>
                            {{ $opcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botones --}}
            <div class="md:col-span-4 flex gap-2 justify-end">
                <a href="{{ route('actividades.registradas') }}" 
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition inline-flex items-center gap-2">
                    <i class="fas fa-redo"></i>
                    <span>Limpiar</span>
                </a>
                <a href="{{ route('actividades.create') }}" 
                   class="px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition inline-flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Nueva Actividad</span>
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
                            <th scope="col" class="px-6 py-3 text-gray-700 dark:text-gray-300">Título</th>
                            <th scope="col" class="px-6 py-3 text-gray-700 dark:text-gray-300">Autor</th>
                            <th scope="col" class="px-6 py-3 text-gray-700 dark:text-gray-300">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-gray-700 dark:text-gray-300">Área</th>
                            <th scope="col" class="px-6 py-3 text-center text-gray-700 dark:text-gray-300">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($actividades as $actividad)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                    {{ $actividad->titulo }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $actividad->autor ?? 'Anónimo' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        {{ $actividad->tipo_area ?? 'Sin área' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        {{-- Ver --}}
                                        <a href="{{ route('actividades.show', $actividad->id) }}" 
                                           class="btn-square bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition" 
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('actividades.edit', $actividad->id) }}" 
                                           class="btn-square bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800 transition" 
                                           title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
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

        {{-- 🔄 Paginación con filtros persistentes --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Mostrando {{ $actividades->firstItem() }} a {{ $actividades->lastItem() }} de {{ $actividades->total() }} actividades
            </div>
            <div>
                {{ $actividades->appends(request()->query())->links() }}
            </div>
        </div>

    @else
        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 rounded-lg p-6 text-center">
            <i class="fas fa-info-circle text-3xl mb-3"></i>
            <p class="text-lg font-medium">No se encontraron actividades</p>
            <p class="text-sm mt-1">Intenta ajustar los filtros de búsqueda</p>
        </div>
    @endif
</div>

{{-- Modal de Confirmación de Eliminación --}}
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

{{-- Formulario oculto para eliminación --}}
<form id="form-eliminar-actividad" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="{{ route('actividades.registradas') }}"]');
    const buscarInput = form?.querySelector('input[name="buscar"]');
    const tipoAreaSelect = form?.querySelector('select[name="tipo_area"]');

    // Enviar automáticamente al cambiar el select
    if (tipoAreaSelect) {
        tipoAreaSelect.addEventListener('change', () => {
            form.submit();
        });
    }

    // Enviar automáticamente al escribir en el input (con retardo)
    if (buscarInput) {
        let timer;
        buscarInput.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                form.submit();
            }, 600);
        });
    }
});

// Funciones para el modal de eliminación
let actividadIdAEliminar = null;

function confirmarEliminacionActividad(id) {
    actividadIdAEliminar = id;
    document.getElementById('modal-eliminar-actividad').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function cerrarModalEliminar() {
    document.getElementById('modal-eliminar-actividad').classList.add('hidden');
    document.body.style.overflow = 'auto';
    actividadIdAEliminar = null;
}

function ejecutarEliminacion() {
    if (actividadIdAEliminar) {
        const form = document.getElementById('form-eliminar-actividad');
        form.action = "{{ route('actividades.destroy', ':id') }}".replace(':id', actividadIdAEliminar);
        form.submit();
    }
}

// Cerrar modal con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalEliminar();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modal-eliminar-actividad')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalEliminar();
    }
});
</script>
@endsection