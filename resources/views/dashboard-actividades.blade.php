@extends('layouts.master')

@section('title', 'Registrar Actividad')

@section('content')
@php
    $hoy = date('Y-m-d');
@endphp

<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📌 Registrar Nueva Actividad</h2>

        {{-- Alerta visual para fecha inválida --}}
        <div id="alerta-fecha" class="hidden mb-4 p-3 rounded-lg bg-yellow-100 text-yellow-700 border border-yellow-300">
            ⚠️ No puedes registrar una actividad con fecha futura.
        </div>

        <form action="{{ route('actividades.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Título --}}
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" name="titulo" id="titulo"
                       class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            {{-- Autor + Fecha --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="autor" class="block text-sm font-medium text-gray-700">Autor</label>
                    <input type="text" name="autor" id="autor"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" max="{{ $hoy }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>
            </div>

            {{-- Área --}}
            <div>
                <label for="tipo_area" class="block text-sm font-medium text-gray-700">Área</label>
                <select name="tipo_area" id="tipo_area"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccionar área</option>
                    <option value="Agua potable">Agua potable</option>
                    <option value="Bienestar Social y Desarrollo Rural">Bienestar Social y Desarrollo Rural</option>
                    <option value="Catastro">Catastro</option>
                    <option value="Contraloria Interna">Contraloria Interna</option>
                    <option value="Deportes">Deportes</option>
                    <option value="DIF">DIF</option>
                    <option value="Informática">Informática</option>
                    <option value="Limpia">Limpia</option>
                    <option value="Obras Publicas">Obras Publicas</option>
                    <option value="Oficialia Mayor">Oficialia Mayor</option>
                    <option value="Presidencia">Presidencia</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Registro Civil">Registro Civil</option>
                    <option value="Regidores">Regidores</option>
                    <option value="Reglamentos">Reglamentos</option>
                    <option value="Secretaria General">Secretaria General</option>
                    <option value="Seguridad Publica">Seguridad Publica</option>
                    <option value="Sindicatura">Sindicatura</option>
                    <option value="Tesoreria">Tesoreria</option>
                    <option value="Transito">Transito</option>
                </select>
            </div>

            {{-- Resumen --}}
            <div>
                <label for="resumen" class="block text-sm font-medium text-gray-700">Resumen</label>
                <textarea name="resumen" id="resumen" rows="3"
                          class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            {{-- Presupuesto + Tipo Presupuesto --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="presupuesto" class="block text-sm font-medium text-gray-700">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto" step="0.01"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="tipo_presupuesto" class="block text-sm font-medium text-gray-700">Tipo de Presupuesto</label>
                    <select name="tipo_presupuesto" id="tipo_presupuesto"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar</option>
                        <option value="Municipal">Municipal</option>
                        <option value="Estatal">Estatal</option>
                        <option value="Federal">Federal</option>
                    </select>
                </div>
            </div>
            {{-- Contenido --}}
            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700">Contenido</label>
                <textarea name="contenido" id="contenido" rows="5"
                          class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>



            {{-- Foto --}}
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto"
                       class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('actividades.registradas') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancelar</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInput = document.getElementById('fecha');
        const alerta = document.getElementById('alerta-fecha');

        fechaInput.addEventListener('input', function () {
            const valor = this.value;
            const fechaIngresada = new Date(valor);
            const hoy = new Date();

            fechaIngresada.setHours(0, 0, 0, 0);
            hoy.setHours(0, 0, 0, 0);

            if (fechaIngresada > hoy) {
                alerta.classList.remove('hidden');
                this.value = '';
            } else {
                alerta.classList.add('hidden');
            }
        });
    });
</script>
@endsection
