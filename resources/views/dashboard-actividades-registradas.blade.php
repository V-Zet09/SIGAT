@extends('layouts.master')

@section('title', 'Actividades Registradas')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/libs/glightbox/css/glightbox.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .btn-square {
        width: 48px;
        height: 48px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">Actividades Registradas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🔎 Buscador y filtro --}}
    <form method="GET" action="{{ route('actividades.registradas') }}" class="row mb-2">
        <div class="col-md-4">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar actividad" value="{{ request('buscar') }}">
        </div>
        <div class="col-md-4">
            <select name="tipo_area" class="form-select">
                <option value="">Filtrar por: Área</option>
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
                    <option value="{{ $opcion }}" {{ request('tipo_area') == $opcion ? 'selected' : '' }}>{{ $opcion }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('actividades.registradas') }}" class="btn btn-outline-light">
        Limpiar filtros
    </a>
    <a href="{{ route('actividades.create') }}" class="btn btn-success">
        Crear Actividad
    </a>
        </div>
    </form>

    {{-- 📋 Tabla de actividades --}}
    @if(isset($actividades) && $actividades->count())
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-600">
                <thead class="text-xs text-gray-800 uppercase bg-gray-100 dark:bg-green-800 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Título</th>
                        <th scope="col" class="px-6 py-3">Autor</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Área</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actividades as $actividad)
                        <tr class="bg-white border-b dark:bg-gray-600 dark:border-gray-400">
                            <td>{{ $actividad->titulo }}</td>
                            <td>{{ $actividad->autor ?? 'Anónimo' }}</td>
                            <td>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $actividad->tipo_area ?? 'Sin área' }}</td>


                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="btn btn-outline-primary btn-square" title="Ver">
                                        <i class="fas fa-eye fa-lg"></i>
                                    </a>
                                    <a href="{{ route('actividades.edit', $actividad->id) }}" class="btn btn-outline-success btn-square" title="Editar">
                                        <i class="fas fa-pencil-alt fa-lg"></i>
                                    </a>
                                    <form action="{{ route('actividades.destroy', $actividad->id) }}" method="POST" onsubmit="return confirm('⚠️ Esta acción eliminará la actividad permanentemente.\n\n¿Estás seguro de continuar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-square" title="Eliminar">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>
                                    </form>
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
        <div class="alert alert-info">
            No se encontraron actividades con los filtros aplicados.
        </div>
    @endif
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action="{{ route('actividades.registradas') }}"]');
        const buscarInput = form.querySelector('input[name="buscar"]');
        const tipoAreaSelect = form.querySelector('select[name="tipo_area"]');

        // Enviar automáticamente al cambiar el select
        tipoAreaSelect.addEventListener('change', () => {
            form.submit();
        });

        // Enviar automáticamente al escribir en el input (con retardo)
        let timer;
        buscarInput.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                form.submit();
            }, 600); // Espera 600ms después de dejar de escribir
        });
    });
</script>
@endsection

@endsection