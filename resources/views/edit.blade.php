@extends('layouts.master')

@section('title', 'Editar Actividad')

@section('content')
@php
    $hoy = date('Y-m-d');
@endphp

<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">✏️ Editar Actividad</h2>

        <form action="{{ route('actividades.update', $actividad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" name="titulo" id="titulo"
                       value="{{ old('titulo', $actividad->titulo) }}"
                       class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                              focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Autor y Fecha -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="autor" class="block text-sm font-medium text-gray-700">Autor</label>
                    <input type="text" name="autor" id="autor"
                           value="{{ old('autor', $actividad->autor) }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                                  focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" max="{{ $hoy }}"
                           value="{{ old('fecha', $actividad->fecha) }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                                  focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Área -->
            <!-- Área -->
            <div>
                <label for="tipo_area" class="block text-sm font-medium text-gray-700">Área</label>
                <select name="tipo_area" id="tipo_area"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                            focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccionar área</option>
                    <option value="Agua potable" {{ old('tipo_area', $actividad->tipo_area) == 'Agua potable' ? 'selected' : '' }}>Agua potable</option>
                    <option value="Bienestar Social y Desarrollo Rural" {{ old('tipo_area', $actividad->tipo_area) == 'Bienestar Social y Desarrollo Rural' ? 'selected' : '' }}>Bienestar Social y Desarrollo Rural</option>
                    <option value="Catastro" {{ old('tipo_area', $actividad->tipo_area) == 'Catastro' ? 'selected' : '' }}>Catastro</option>
                    <option value="Contraloria Interna" {{ old('tipo_area', $actividad->tipo_area) == 'Contraloria Interna' ? 'selected' : '' }}>Contraloria Interna</option>
                    <option value="Deportes" {{ old('tipo_area', $actividad->tipo_area) == 'Deportes' ? 'selected' : '' }}>Deportes</option>
                    <option value="DIF" {{ old('tipo_area', $actividad->tipo_area) == 'DIF' ? 'selected' : '' }}>DIF</option>
                    <option value="Informática" {{ old('tipo_area', $actividad->tipo_area) == 'Informática' ? 'selected' : '' }}>Informática</option>
                    <option value="Limpia" {{ old('tipo_area', $actividad->tipo_area) == 'Limpia' ? 'selected' : '' }}>Limpia</option>
                    <option value="Obras Publicas" {{ old('tipo_area', $actividad->tipo_area) == 'Obras Publicas' ? 'selected' : '' }}>Obras Publicas</option>
                    <option value="Oficialia Mayor" {{ old('tipo_area', $actividad->tipo_area) == 'Oficialia Mayor' ? 'selected' : '' }}>Oficialia Mayor</option>
                    <option value="Presidencia" {{ old('tipo_area', $actividad->tipo_area) == 'Presidencia' ? 'selected' : '' }}>Presidencia</option>
                    <option value="Recursos Humanos" {{ old('tipo_area', $actividad->tipo_area) == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos</option>
                    <option value="Registro Civil" {{ old('tipo_area', $actividad->tipo_area) == 'Registro Civil' ? 'selected' : '' }}>Registro Civil</option>
                    <option value="Regidores" {{ old('tipo_area', $actividad->tipo_area) == 'Regidores' ? 'selected' : '' }}>Regidores</option>
                    <option value="Reglamentos" {{ old('tipo_area', $actividad->tipo_area) == 'Reglamentos' ? 'selected' : '' }}>Reglamentos</option>
                    <option value="Secretaria General" {{ old('tipo_area', $actividad->tipo_area) == 'Secretaria General' ? 'selected' : '' }}>Secretaria General</option>
                    <option value="Seguridad Publica" {{ old('tipo_area', $actividad->tipo_area) == 'Seguridad Publica' ? 'selected' : '' }}>Seguridad Publica</option>
                    <option value="Sindicatura" {{ old('tipo_area', $actividad->tipo_area) == 'Sindicatura' ? 'selected' : '' }}>Sindicatura</option>
                    <option value="Tesoreria" {{ old('tipo_area', $actividad->tipo_area) == 'Tesoreria' ? 'selected' : '' }}>Tesoreria</option>
                    <option value="Transito" {{ old('tipo_area', $actividad->tipo_area) == 'Transito' ? 'selected' : '' }}>Transito</option>
                </select>
            </div>

            <!-- Resumen -->
            <div>
                <label for="resumen" class="block text-sm font-medium text-gray-700">Resumen</label>
                <textarea name="resumen" id="resumen" rows="3"
                          class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                                 focus:ring-blue-500 focus:border-blue-500">{{ old('resumen', $actividad->resumen) }}</textarea>
            </div>

            <!-- Contenido -->
            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700">Contenido</label>
                <textarea name="contenido" id="contenido" rows="5"
                          class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                                 focus:ring-blue-500 focus:border-blue-500">{{ old('contenido', $actividad->contenido) }}</textarea>
            </div>

            <!-- Presupuesto y Tipo -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="presupuesto" class="block text-sm font-medium text-gray-700">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto" step="0.01"
                           value="{{ old('presupuesto', $actividad->presupuesto) }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                                  focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="tipo_presupuesto" class="block text-sm font-medium text-gray-700">Tipo de Presupuesto</label>
                    <select name="tipo_presupuesto" id="tipo_presupuesto"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                                   focus:ring-blue-500 focus:border-blue-500">
                        <option value="Municipal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Municipal' ? 'selected' : '' }}>Municipal</option>
                        <option value="Estatal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Estatal' ? 'selected' : '' }}>Estatal</option>
                        <option value="Federal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Federal' ? 'selected' : '' }}>Federal</option>
                    </select>
                </div>
            </div>

            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto"
                       class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                              focus:ring-blue-500 focus:border-blue-500">
                @if($actividad->foto)
                    <p class="text-sm text-gray-500 mt-2">Foto actual:</p>
                    <img src="{{ asset('storage/' . $actividad->foto) }}" alt="Foto actual"
                         class="w-40 mt-2 rounded-lg shadow">
                @endif
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('actividades.registradas') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
