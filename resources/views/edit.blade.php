@extends('layouts.master')

@section('title', 'Editar Actividad')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Actividad</h2>

    <form action="{{ route('actividades.update', $actividad->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $actividad->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" name="autor" class="form-control" value="{{ old('autor', $actividad->autor) }}">
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $actividad->fecha) }}">
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Área</label>
            <select name="tipo_area" id="tipo_area" class="form-select">
                        <option value="Informatica">Informática</option>
                        <option value="Regidores">Regidores</option>
                        <option value="Tesoreria">Tesorería</option>
                    </select>
            </div>

        <div class="mb-3">
            <label for="resumen" class="form-label">Resumen</label>
            <textarea name="resumen" class="form-control" rows="3">{{ old('resumen', $actividad->resumen) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" class="form-control" rows="5">{{ old('contenido', $actividad->contenido) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="presupuesto" class="form-label">Presupuesto</label>
            <input type="number" name="presupuesto" class="form-control" value="{{ old('presupuesto', $actividad->presupuesto) }}">
        </div>

        <div class="mb-3">
            <label for="tipo_presupuesto" class="form-label">Tipo de Presupuesto</label>
             <select name="tipo_presupuesto" id="tipo_presupuesto" class="form-select">
                        <option value="Municipal">Municipal</option>
                        <option value="Estatal">Estatal</option>
                        <option value="Federal">Federal</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('actividades.registradas') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
