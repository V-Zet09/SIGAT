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
    <form method="GET" action="{{ route('actividades.registradas') }}" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar actividad" value="{{ request('buscar') }}">
        </div>
        <div class="col-md-4">
            <select name="area" class="form-select">
                <option value="">Filtrar por: Área</option>
                @foreach(['Agua potable', 'Alumbrado público', 'Desarrollo rural', 'Bienestar animal'] as $opcion)
                    <option value="{{ $opcion }}" {{ request('area') == $opcion ? 'selected' : '' }}>{{ $opcion }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('actividades.create') }}" class="btn btn-success">
                Crear Actividad
            </a>
        </div>
    </form>

    {{-- 📋 Tabla de actividades --}}
    @if($actividades->count())
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Fecha</th>
                        <th>Área</th>
                        <th>Tipo de Actividad</th>
                        <th>Resumen</th>
                        <th>Contenido</th>
                        <th>Presupuesto</th>
                        <th>Tipo de Presupuesto</th>
                        <th>Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actividades as $actividad)
                        <tr>
                            <td>{{ $actividad->titulo }}</td>
                            <td>{{ $actividad->autor ?? 'Anónimo' }}</td>
                            <td>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $actividad->area ?? 'Sin área' }}</td>
                            <td>{{ $actividad->tipo_actividad ?? 'No especificado' }}</td>
                            <td>
                                {{ Str::limit($actividad->resumen, 80, '...') }}
                                @if(strlen($actividad->resumen) > 80)
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="text-primary ms-1">Ver más</a>
                                @endif
                            </td>
                            <td>
                                {{ Str::limit($actividad->contenido, 80, '...') }}
                                @if(strlen($actividad->contenido) > 80)
                                    <a href="{{ route('actividades.show', $actividad->id) }}" class="text-primary ms-1">Ver más</a>
                                @endif
                            </td>
                            <td>${{ number_format($actividad->presupuesto, 2) }}</td>
                            <td>{{ $actividad->tipo_presupuesto ?? 'N/A' }}</td>
                            <td>
                                @if($actividad->foto)
                                    <a href="{{ asset('storage/' . $actividad->foto) }}" target="_blank">Ver imagen</a>
                                @else
                                    No adjunto
                                @endif
                            </td>
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
@endsection
