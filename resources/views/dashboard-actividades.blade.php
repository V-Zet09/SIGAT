@extends('layouts.master')

@section('title', 'Registrar Actividad')

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
.ql-toolbar button:hover .ql-stroke { 
    stroke: #2563eb !important; 
}
.ql-toolbar button:hover .ql-fill { 
    fill: #2563eb !important; 
}
.ql-toolbar button.ql-active .ql-stroke { 
    stroke: #2563eb !important; 
}
.ql-toolbar button.ql-active .ql-fill { 
    fill: #2563eb !important; 
}

/* Estilos para modo oscuro */
.dark .ql-toolbar .ql-stroke {
    stroke: #9ca3af;
}
.dark .ql-toolbar .ql-fill {
    fill: #9ca3af;
}
.dark .ql-toolbar .ql-picker-label {
    color: #e5e7eb;
}
.dark .ql-toolbar button:hover .ql-stroke,
.dark .ql-toolbar button.ql-active .ql-stroke {
    stroke: #60a5fa !important;
}
.dark .ql-toolbar button:hover .ql-fill,
.dark .ql-toolbar button.ql-active .ql-fill {
    fill: #60a5fa !important;
}
.dark .ql-toolbar .ql-picker-label:hover,
.dark .ql-toolbar .ql-picker-label.ql-active {
    color: #60a5fa;
}
/* Picker (dropdowns) en modo oscuro */
.dark .ql-toolbar .ql-picker-options {
    background: #1f2937;
    border-color: #374151;
}
.dark .ql-toolbar .ql-picker-item {
    color: #e5e7eb;
}
.dark .ql-toolbar .ql-picker-item:hover {
    color: #60a5fa;
    background: #374151;
}
/* Placeholder */
.ql-editor.ql-blank::before {
    color: #9ca3af;
}
.dark .ql-editor.ql-blank::before {
    color: #6b7280;
}
/* Nombres en selectores */
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="arial"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="arial"]::before {
    content: 'Arial' !important;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="times"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="times"]::before {
    content: 'Times New Roman' !important;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="georgia"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="georgia"]::before {
    content: 'Georgia' !important;
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="verdana"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="verdana"]::before {
    content: 'Verdana' !important;
}
.ql-snow .ql-picker.ql-font .ql-picker-label::before {
    content: 'Fuente' !important;
}

/* Tamaños */
.ql-snow .ql-picker.ql-size .ql-picker-label::before {
    content: 'Normal' !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="small"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="small"]::before {
    content: 'Pequeño' !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="large"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="large"]::before {
    content: 'Grande' !important;
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="huge"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="huge"]::before {
    content: 'Enorme' !important;
}

/* Títulos */
.ql-snow .ql-picker.ql-header .ql-picker-label::before {
    content: 'Normal' !important;
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="1"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="1"]::before {
    content: 'Título 1' !important;
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="2"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="2"]::before {
    content: 'Título 2' !important;
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="3"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="3"]::before {
    content: 'Título 3' !important;
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
.dark input[type="text"]::placeholder,
.dark textarea::placeholder {
    color: #6b7280;
}
/* Chrome autofill fix modo oscuro */
.dark input:-webkit-autofill,
.dark input:-webkit-autofill:hover,
.dark input:-webkit-autofill:focus {
    -webkit-text-fill-color: #e5e7eb !important;
    -webkit-box-shadow: 0 0 0px 1000px #374151 inset !important;
    transition: background-color 5000s ease-in-out 0s;
}

/* Estilos para el contenedor de imagenes con botón de eliminar */
.relative.inline-block.m-1 {
    position: relative;
    display: inline-block;
    margin: 0.25rem;
}
.relative.inline-block.m-1 button {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #dc2626;
    color: white;
    border-radius: 9999px;
    width: 1.25rem;
    height: 1.25rem;
    font-size: 0.75rem;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: none;
    user-select: none;
}
.relative.inline-block.m-1 button:hover {
    background-color: #b91c1c;
}
</style>
@endsection

@section('content')
@php
    $hoy = date('Y-m-d');
    $user = auth()->user();
    // Definimos los roles de alto nivel que pueden ver todas las áreas
    $esAltoNivel = $user->hasRole(['Administrador', 'Presidente Municipal', 'Síndico Procurador', 'Regidor']);
    
    // Lista completa de áreas del sistema
    $todasLasAreas = [
        'Agua potable', 'Bienestar Social y Desarrollo Rural', 'Catastro', 
        'Contraloria Interna', 'Deportes', 'DIF', 'Informática', 'Limpia', 
        'Obras Publicas', 'Oficialia Mayor', 'Presidencia', 'Recursos Humanos', 
        'Registro Civil', 'Regidores', 'Reglamentos', 'Secretaria General', 
        'Seguridad Publica', 'Sindicatura', 'Tesoreria', 'Transito'
    ];
@endphp

<div class="shadow-2xl rounded-3xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-8 mx-auto max-w-[80vw]">
    <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 dark:from-green-700 dark:via-emerald-700 dark:to-teal-700 p-6 shadow-xl">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                    <i class="fas fa-plus-circle text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Registrar Nueva Actividad</h1>
                    <p class="text-base text-green-100">Complete el formulario para registrar una actividad</p>
                </div>
            </div>
            <a href="{{ route('actividades.registradas') }}" class="group flex items-center space-x-2 rounded-lg bg-white px-6 py-3 text-base font-semibold text-green-600 shadow-lg transition hover:scale-105">
                <i class="fas fa-list-check text-lg transition"></i>
                <span>Actividades Registradas</span>
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
        <div id="alerta-fecha" class="hidden mb-4 p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 border border-yellow-300 dark:border-yellow-700">
            ⚠️ No puedes registrar una actividad con fecha futura.
        </div>

        <form id="formActividad" action="{{ route('actividades.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título</label>
                <input type="text" name="titulo" id="titulo"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                       required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="autor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Autor</label>
                    <input type="text" name="autor" id="autor"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                </div>
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha</label>
                    <input type="date" name="fecha" id="fecha" max="{{ $hoy }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                           required>
                </div>
            </div>

            {{-- SELECT DE ÁREA CON LÓGICA DE ROLES --}}
            <div>
                <label for="tipo_area" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Área</label>
                
                {{-- Si NO es alto nivel, mostramos input hidden para enviar el valor correcto aunque el select esté disabled --}}
                @if(!$esAltoNivel)
                    <input type="hidden" name="tipo_area" value="{{ $user->area }}">
                @endif

                <select name="tipo_area" id="tipo_area" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 disabled:bg-gray-100 disabled:text-gray-500 dark:disabled:bg-gray-800"
                        @if(!$esAltoNivel) disabled @endif>
                    
                    <option value="">Seleccionar área</option>

                    @foreach($todasLasAreas as $area)
                        {{-- Solo mostramos la opción si es alto nivel O si coincide con el área del usuario --}}
                        @if($esAltoNivel || $user->area === $area)
                            <option value="{{ $area }}" 
                                {{ (old('tipo_area') == $area || (!$esAltoNivel && $user->area === $area)) ? 'selected' : '' }}>
                                {{ $area }}
                            </option>
                        @endif
                    @endforeach
                </select>

                @if(!$esAltoNivel)
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        Tu área está preseleccionada automáticamente: <strong>{{ $user->area }}</strong>
                    </p>
                @endif
            </div>

            <div>
                <label for="resumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Resumen</label>
                <div id="resumen-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="resumen" id="resumen-content" class="hidden"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="presupuesto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto" step="0.01"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                </div>
                <div>
                    <label for="tipo_presupuesto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Presupuesto</label>
                    <select name="tipo_presupuesto" id="tipo_presupuesto"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                        <option value="">Seleccionar</option>
                        <option value="Municipal">Municipal</option>
                        <option value="Estatal">Estatal</option>
                        <option value="Federal">Federal</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenido</label>
                <div id="contenido-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="contenido" id="contenido-content" class="hidden"></textarea>
            </div>

            <div>
                <label for="fotos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fotos</label>
                <input type="file" name="fotos[]" id="fotos" multiple
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                       accept="image/*">
                <p id="fotos-error" class="hidden text-red-600 text-sm mt-1">Solo puedes subir máximo 5 fotos</p>
                <div id="preview-container" class="mt-2 flex flex-wrap gap-2"></div>
                <p id="fotos-count" class="mt-1 text-sm text-gray-700 dark:text-gray-300"></p>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('actividades.registradas') }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">Cancelar</a>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 dark:bg-green-500 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition">
                    Guardar
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
    const fechaInput = document.getElementById('fecha');
    const alerta = document.getElementById('alerta-fecha');

    fechaInput.addEventListener('input', function() {
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

    const traducciones = {
        'Bold': 'Negrita',
        'Italic': 'Cursiva',
        'Underline': 'Subrayado',
        'Strike': 'Tachado',
        'Link': 'Enlace',
        'Image': 'Imagen',
        'Clean': 'Limpiar',
        'Ordered List': 'Lista numerada',
        'Bullet List': 'Lista con viñetas'
    };

    function traducir() {
        document.querySelectorAll('.ql-toolbar button').forEach(el => {
            const title = el.getAttribute('title');
            if (traducciones[title]) el.setAttribute('title', traducciones[title]);
        });
    }

    const editores = [
        {id: 'resumen-editor', hidden: 'resumen-content'},
        {id: 'contenido-editor', hidden: 'contenido-content'}
    ];

    editores.forEach(cfg => {
        const el = document.getElementById(cfg.id);
        if (el) {
            const quill = new Quill(`#${cfg.id}`, {
                theme: 'snow',
                modules: {toolbar: toolbarOptions}
            });

            quill.on('text-change', () => {
                document.getElementById(cfg.hidden).value = quill.root.innerHTML;
            });
        }
    });

    traducir();

    // Manejo de imágenes con FormData
    const inputFotos = document.getElementById('fotos');
    const errorMsg = document.getElementById('fotos-error');
    const previewContainer = document.getElementById('preview-container');
    const fotoCount = document.getElementById('fotos-count');

    let archivosSeleccionados = [];

    inputFotos.addEventListener('change', function() {
        const nuevosArchivos = Array.from(this.files);

        if (archivosSeleccionados.length + nuevosArchivos.length > 5) {
            errorMsg.classList.remove('hidden');
            this.value = '';
            return;
        }
        errorMsg.classList.add('hidden');

        archivosSeleccionados = archivosSeleccionados.concat(nuevosArchivos);
        this.value = '';

        actualizarPrevisualizacion();
    });

    function actualizarPrevisualizacion() {
        previewContainer.innerHTML = '';
        fotoCount.textContent = `Has seleccionado ${archivosSeleccionados.length} foto(s)`;

        archivosSeleccionados.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.classList.add('relative', 'inline-block', 'm-1');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('h-20', 'w-20', 'object-cover', 'rounded-lg', 'border', 'border-gray-300');

                const btnEliminar = document.createElement('button');
                btnEliminar.type = 'button';
                btnEliminar.textContent = '×';
                btnEliminar.title = 'Eliminar imagen';
                btnEliminar.classList.add('absolute', 'top-0', 'right-0', 'bg-red-600', 'text-white', 'rounded-full', 'w-5', 'h-5', 'text-xs', 'leading-none', 'flex', 'items-center', 'justify-center', 'cursor-pointer', 'hover:bg-red-700');

                btnEliminar.addEventListener('click', () => {
                    archivosSeleccionados.splice(index, 1);
                    actualizarPrevisualizacion();
                });

                div.appendChild(img);
                div.appendChild(btnEliminar);
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    // ENVÍO CON FORMDATA - SOLUCIÓN RECOMENDADA
    const form = document.getElementById('formActividad');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir envío normal

        // Crear FormData desde el formulario
        const formData = new FormData(this);

        // Remover el campo fotos[] que viene vacío del input
        formData.delete('fotos[]');

        // Agregar las fotos seleccionadas manualmente
        archivosSeleccionados.forEach((file) => {
            formData.append('fotos[]', file);
        });

        // Debugging - puedes eliminarlo después de verificar
        console.log('Total de fotos a enviar:', archivosSeleccionados.length);
        for (let pair of formData.entries()) {
            if (pair[0] === 'fotos[]') {
                console.log('Foto:', pair[1].name);
            }
        }

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
                    throw new Error(data.message || 'Error al guardar la actividad');
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al enviar el formulario: ' + error.message);
        });
    });
});
</script>
@endsection
