@extends('layouts.master')

@section('title', 'Editar Actividad')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
<style>
.grid, .flex { display: flex; flex-wrap: wrap; }
.grid-cols-2 { flex-basis: 48%; }
.md\:grid-cols-4 { flex-basis: 23%; }
.gap-3 { gap: 0.75rem; }
.relative.group { position: relative; }
.absolute { position: absolute; }
.top-1 { top: 0.25rem; }
.right-1 { right: 0.25rem; }
.rounded-full { border-radius: 9999px; }
.bg-red-600 { background-color: #dc2626; }
.text-white { color: #fff; }
.px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
.py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
.text-xs { font-size: 0.75rem; }
.hover\:bg-red-700:hover { background-color: #b91c1c; }
</style>
@endsection

@section('content')
@php
    $hoy = date('Y-m-d');
    $fechaValor = old('fecha', isset($actividad->fecha) ? \Illuminate\Support\Carbon::parse($actividad->fecha)->format('Y-m-d') : '');
@endphp

<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">✏️ Editar Actividad</h2>

        <form id="activityForm" action="{{ route('actividades.update', $actividad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título <span class="text-red-500">*</span></label>
                <input type="text" name="titulo" id="titulo" required
                       value="{{ old('titulo', $actividad->titulo) }}"
                       class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="autor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Autor <span class="text-red-500">*</span></label>
                    <input type="text" name="autor" id="autor" required
                           value="{{ old('autor', $actividad->autor) }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha <span class="text-red-500">*</span></label>
                    <input type="date" name="fecha" id="fecha" max="{{ $hoy }}" required
                           value="{{ $fechaValor }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
            </div>
            <div>
                <label for="tipo_area" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Área <span class="text-red-500">*</span></label>
                <select name="tipo_area" id="tipo_area" required
                        class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <option value="">Seleccionar área</option>
                    @foreach([
                        'Agua potable', 'Bienestar Social y Desarrollo Rural', 'Catastro', 'Contraloria Interna',
                        'Deportes', 'DIF', 'Informática', 'Limpia', 'Obras Publicas', 'Oficialia Mayor', 'Presidencia',
                        'Recursos Humanos', 'Registro Civil', 'Regidores', 'Reglamentos', 'Secretaria General',
                        'Seguridad Publica', 'Sindicatura', 'Tesoreria', 'Transito'
                    ] as $area)
                        <option value="{{ $area }}" {{ old('tipo_area', $actividad->tipo_area) == $area ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="resumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Resumen</label>
                <div id="resumen-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="resumen" id="resumen-content" class="hidden">{{ old('resumen', $actividad->resumen) }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="presupuesto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto" step="0.01"
                           value="{{ old('presupuesto', $actividad->presupuesto) }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label for="tipo_presupuesto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Presupuesto</label>
                    <select name="tipo_presupuesto" id="tipo_presupuesto"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Seleccionar</option>
                        <option value="Municipal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Municipal' ? 'selected' : '' }}>Municipal</option>
                        <option value="Estatal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Estatal' ? 'selected' : '' }}>Estatal</option>
                        <option value="Federal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Federal' ? 'selected' : '' }}>Federal</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenido</label>
                <div id="contenido-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="contenido" id="contenido-content" class="hidden">{{ old('contenido', $actividad->contenido) }}</textarea>
            </div>

            {{-- FOTOS - MÚLTIPLES --}}
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fotos</label>
                <input type="file" name="foto[]" id="foto" accept="image/*" multiple
                       class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

{{-- Mostrar imágenes ya guardadas y botón cambiar --}}
@if(isset($actividad->fotos) && is_array($actividad->fotos) && count($actividad->fotos) > 0)
    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3" id="fotos-existentes">
        @foreach($actividad->fotos as $index => $foto)
            @if(!empty($foto))
                <div class="relative group">
                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto actual"
                         id="preview-foto-{{ $index }}"
                         class="w-32 h-24 object-cover rounded-lg shadow-md border-2 border-gray-200 dark:border-gray-600">
                    <button type="button"
                        class="absolute bottom-1 left-1 bg-blue-600 text-white rounded px-2 py-1 text-xs hover:bg-blue-700"
                        onclick="document.getElementById('cambiar-foto-{{ $index }}').click()">
                        Cambiar
                    </button>
                    <input type="file"
                        name="cambiar_foto[{{ $index }}]"
                        id="cambiar-foto-{{ $index }}"
                        accept="image/*"
                        class="hidden"
                        onchange="previewFotoCambio(event, {{ $index }})">
                    <!-- Campo oculto para enviar la ruta anterior al backend -->
                    <input type="hidden" name="foto_anterior[{{ $index }}]" value="{{ $foto }}">
                </div>
            @endif
        @endforeach
    </div>
@endif

@if(isset($actividad->foto) && !empty($actividad->foto) && (!isset($actividad->fotos) || empty($actividad->fotos)))
    <div class="mt-4 flex gap-4">
        <div class="relative group">
            <img src="{{ asset('storage/' . $actividad->foto) }}" alt="Foto actual"
                id="preview-foto-legacy"
                class="w-32 h-24 object-cover rounded-lg shadow-md border-2 border-gray-200 dark:border-gray-600">
            <button type="button"
                class="absolute bottom-1 left-1 bg-blue-600 text-white rounded px-2 py-1 text-xs hover:bg-blue-700"
                onclick="document.getElementById('cambiar-foto-legacy').click()">
                Cambiar
            </button>
            <input type="file"
                name="cambiar_foto_legacy"
                id="cambiar-foto-legacy"
                accept="image/*"
                class="hidden"
                onchange="previewFotoCambio(event, 'legacy')">
            <input type="hidden" name="foto_anterior_legacy" value="{{ $actividad->foto }}">
        </div>
    </div>
@endif
                @if(isset($actividad->foto) && !empty($actividad->foto) && (!isset($actividad->fotos) || empty($actividad->fotos)))
                    <div class="mt-4 flex gap-4">
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $actividad->foto) }}" alt="Foto actual"
                                 class="w-32 h-24 object-cover rounded-lg shadow-md border-2 border-gray-200 dark:border-gray-600">
                            <!-- Eliminar manual si quieres, pero el estándar es multi como arriba -->
                        </div>
                    </div>
                @endif
                <div id="preview-fotos-nuevas" class="mt-4 flex flex-wrap gap-3"></div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('actividades.registradas') }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">Cancelar</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                    <i class="ri-save-line mr-1"></i>
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Quill editors
    const resumenHidden = document.getElementById('resumen-content');
    const contenidoHidden = document.getElementById('contenido-content');
    var quillResumen = new Quill('#resumen-editor', {theme:'snow'});
    if (resumenHidden.value) quillResumen.root.innerHTML = resumenHidden.value;
    quillResumen.on('text-change', function () { resumenHidden.value = quillResumen.root.innerHTML; });
    var quillContenido = new Quill('#contenido-editor', {theme:'snow'});
    if (contenidoHidden.value) quillContenido.root.innerHTML = contenidoHidden.value;
    quillContenido.on('text-change', function () { contenidoHidden.value = quillContenido.root.innerHTML; });

    // ==========================
    // FOTOS NUEVAS (con X)
    // ==========================
    const fileInput        = document.getElementById('foto');
    const previewContainer = document.getElementById('preview-fotos-nuevas');
    let nuevas = [];

    // Cuando el usuario selecciona archivos
    fileInput && fileInput.addEventListener('change', function () {
        nuevas = Array.from(fileInput.files);   // guardamos los File en el arreglo
        renderNuevasPreviews();
    });

    // Render de previews + botón X
    function renderNuevasPreviews() {
        previewContainer.innerHTML = '';

        nuevas.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}"
                         class="w-32 h-24 object-cover rounded-lg shadow-md border-2 border-green-500" />
                    <span class="absolute top-1 left-1 bg-green-600 text-white rounded px-2 py-1 text-xs">
                        Nueva
                    </span>
                    <button type="button"
                            class="absolute top-1 right-1 rounded-full bg-red-600 text-white px-2 py-1 text-xs hover:bg-red-700"
                            onclick="eliminarNuevaFoto(${idx})">
                        X
                    </button>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        // Reconstruir FileList del input para que solo envíe lo que queda en 'nuevas'
        const dataTransfer = new DataTransfer();
        nuevas.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    // Eliminar una foto nueva por índice
    window.eliminarNuevaFoto = function (idx) {
        nuevas.splice(idx, 1);     // quitamos del arreglo
        renderNuevasPreviews();    // y volvemos a pintar / actualizar FileList
    };

    // ================================
    // Cambio de fotos ya existentes
    // ================================
    window.previewFotoCambio = function(event, index) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let img;
                if (index === 'legacy') {
                    img = document.getElementById('preview-foto-legacy');
                } else {
                    img = document.getElementById('preview-foto-' + index);
                }
                if (img) {
                    img.src = e.target.result;
                    img.classList.add('border-green-600');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
});
</script>
@endsection

