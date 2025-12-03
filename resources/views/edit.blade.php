@extends('layouts.master')

@section('title', 'Editar Actividad')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
<style>
/* Fuentes */
.ql-font-arial { font-family: Arial, sans-serif; }
.ql-font-times { font-family: 'Times New Roman', serif; }
.ql-font-georgia { font-family: Georgia, serif; }
.ql-font-verdana { font-family: Verdana, sans-serif; }

/* Tamaños */
.ql-size-small { font-size: 12px; }
.ql-size-large { font-size: 18px; }
.ql-size-huge { font-size: 24px; }

/* Editor */
.ql-toolbar.ql-snow {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem 0.5rem 0 0;
    background: #f9fafb;
}
.dark .ql-toolbar.ql-snow {
    background: #1f2937;
    border-color: #374151;
}
.ql-container.ql-snow {
    border: 1px solid #d1d5db;
    border-top: none;
    border-radius: 0 0 0.5rem 0.5rem;
    min-height: 150px;
    background: #ffffff;
}
.dark .ql-container.ql-snow {
    border-color: #374151;
    background: #111827;
}
.ql-editor {
    min-height: 150px;
    padding: 15px;
    color: #111827;
}
.dark .ql-editor {
    color: #e5e7eb;
}

/* Inputs modo oscuro */
input[type="text"],
input[type="date"],
input[type="number"],
select,
textarea {
    color-scheme: light;
}
.dark input[type="text"],
.dark input[type="date"],
.dark input[type="number"],
.dark select,
.dark textarea {
    color: #e5e7eb !important;
    color-scheme: dark;
}
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

        <form id="formEditarActividad" action="{{ route('actividades.update', $actividad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
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
                    <label for="autor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Autor</label>
                    <input type="text" name="autor" id="autor"
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

            {{-- FOTOS --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Fotos ({{ is_array($actividad->fotos) ? count($actividad->fotos) : 0 }}/5)
                </label>

                {{-- Fotos existentes con botón Cambiar --}}
                @if(isset($actividad->fotos) && is_array($actividad->fotos) && count($actividad->fotos) > 0)
                    <div class="mb-4 grid grid-cols-2 md:grid-cols-4 gap-3 foto-existente" id="fotos-existentes">
                        @foreach($actividad->fotos as $index => $foto)
                            @if(!empty($foto))
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $index + 1 }}"
                                         id="preview-foto-{{ $index }}"
                                         class="w-full h-32 object-cover rounded-lg shadow-md border-2 border-gray-200 dark:border-gray-600">
                                    
                                    <button type="button"
                                            class="absolute bottom-2 left-2 bg-blue-600 text-white rounded px-2 py-1 text-xs hover:bg-blue-700 transition"
                                            onclick="document.getElementById('cambiar-foto-{{ $index }}').click()">
                                        Cambiar
                                    </button>
                                    
                                    <input type="file"
                                           name="cambiar_foto[{{ $index }}]"
                                           id="cambiar-foto-{{ $index }}"
                                           accept="image/*"
                                           class="hidden"
                                           onchange="previewFotoCambio(event, {{ $index }})">
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- Input para AGREGAR fotos nuevas --}}
                @php
                    $fotosActualesCount = is_array($actividad->fotos) ? count($actividad->fotos) : 0;
                    $puedeAgregar = 5 - $fotosActualesCount;
                @endphp
                @if($puedeAgregar > 0)
                    <div class="mb-2">
                        <label for="fotos-nuevas" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                            Agregar más fotos (puedes agregar hasta {{ $puedeAgregar }} más)
                        </label>
                        <input type="file" name="fotos[]" id="fotos-nuevas" multiple accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>
                    <div id="preview-fotos-nuevas" class="grid grid-cols-2 md:grid-cols-4 gap-3"></div>
                @else
                    <p class="text-sm text-yellow-600 dark:text-yellow-400">
                        Ya tienes el máximo de 5 fotos. Elimina alguna para agregar más.
                    </p>
                @endif
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('actividades.registradas') }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Cancelar
                </a>
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
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de Quill
    const Font = Quill.import('formats/font');
    Font.whitelist = ['arial', 'times', 'georgia', 'verdana'];
    Quill.register(Font, true);

    const toolbarOptions = [
        [{'font': ['arial', 'times', 'georgia', 'verdana']}],
        [{'size': ['small', false, 'large', 'huge']}],
        ['bold', 'italic', 'underline', 'strike'],
        [{'color': []}, {'background': []}],
        [{'header': [1, 2, 3, false]}],
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'indent': '-1'}, {'indent': '+1'}],
        [{'align': []}],
        ['link', 'image'],
        ['clean']
    ];

    // Editor Resumen
    const resumenHidden = document.getElementById('resumen-content');
    const quillResumen = new Quill('#resumen-editor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });
    if (resumenHidden.value) {
        quillResumen.root.innerHTML = resumenHidden.value;
    }
    quillResumen.on('text-change', () => {
        resumenHidden.value = quillResumen.root.innerHTML;
    });

    // Editor Contenido
    const contenidoHidden = document.getElementById('contenido-content');
    const quillContenido = new Quill('#contenido-editor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });
    if (contenidoHidden.value) {
        quillContenido.root.innerHTML = contenidoHidden.value;
    }
    quillContenido.on('text-change', () => {
        contenidoHidden.value = quillContenido.root.innerHTML;
    });

    // ===================================
    // SISTEMA DE FOTOS NUEVAS (con acumulación)
    // ===================================
    const inputFotosNuevas = document.getElementById('fotos-nuevas');
    const previewContainerNuevas = document.getElementById('preview-fotos-nuevas');
    const form = document.getElementById('formEditarActividad');

    let fotosNuevasSeleccionadas = [];

    if (inputFotosNuevas) {
        inputFotosNuevas.addEventListener('change', function() {
            const nuevosArchivos = Array.from(this.files);
            
            // Contar fotos actuales
            const fotosExistentesCount = document.querySelectorAll('#fotos-existentes .relative').length || 0;
            const totalFotos = fotosExistentesCount + fotosNuevasSeleccionadas.length + nuevosArchivos.length;

            if (totalFotos > 5) {
                alert(`Solo puedes tener máximo 5 fotos. Ya tienes ${fotosExistentesCount} foto(s) guardada(s) y ${fotosNuevasSeleccionadas.length} seleccionada(s).`);
                this.value = '';
                return;
            }

            // Agregar al array de fotos nuevas (acumulando)
            fotosNuevasSeleccionadas = fotosNuevasSeleccionadas.concat(nuevosArchivos);
            this.value = '';

            actualizarPreviewNuevas();
        });
    }

    function actualizarPreviewNuevas() {
        if (!previewContainerNuevas) return;
        
        previewContainerNuevas.innerHTML = '';

        fotosNuevasSeleccionadas.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.classList.add('relative', 'group');

                div.innerHTML = `
                    <img src="${e.target.result}"
                         class="w-full h-32 object-cover rounded-lg shadow-md border-2 border-green-500">
                    <span class="absolute top-2 left-2 bg-green-600 text-white rounded px-2 py-1 text-xs">
                        Nueva
                    </span>
                    <button type="button"
                            class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition"
                            onclick="eliminarFotoNueva(${index})">
                        ×
                    </button>
                `;

                previewContainerNuevas.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    // Eliminar una foto nueva por índice
    window.eliminarFotoNueva = function(idx) {
        fotosNuevasSeleccionadas.splice(idx, 1);
        actualizarPreviewNuevas();
    };

    // ENVÍO CON FORMDATA
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Remover el input de fotos nuevas vacío
            formData.delete('fotos[]');

            // Agregar las fotos nuevas seleccionadas manualmente
            fotosNuevasSeleccionadas.forEach((file) => {
                formData.append('fotos[]', file);
            });

            console.log('Fotos nuevas a enviar:', fotosNuevasSeleccionadas.length);

            // Enviar con fetch
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                if (response.ok) {
                    window.location.href = "{{ route('actividades.registradas') }}";
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Error al actualizar');
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
        });
    }

    // ================================
    // Cambio de fotos ya existentes
    // ================================
    window.previewFotoCambio = function(event, index) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-foto-' + index);
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('border-gray-200');
                    img.classList.add('border-blue-500', 'border-4');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
});
</script>
@endsection
