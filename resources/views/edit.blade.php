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
    background: #374151;
    border-color: #4b5563;
}

.ql-container.ql-snow {
    border: 1px solid #d1d5db;
    border-top: none;
    border-radius: 0 0 0.5rem 0.5rem;
    min-height: 150px;
}

.dark .ql-container.ql-snow {
    border-color: #4b5563;
    background: #1f2937;
}

.ql-editor {
    min-height: 150px;
    padding: 15px;
}

.dark .ql-editor {
    color: #f3f4f6;
}

.ql-toolbar button:hover { color: #2563eb !important; }
.ql-toolbar button.ql-active { color: #2563eb !important; }

.dark .ql-toolbar button,
.dark .ql-toolbar .ql-picker-label,
.dark .ql-toolbar .ql-stroke {
    stroke: #d1d5db !important;
}

.dark .ql-toolbar button:hover,
.dark .ql-toolbar button.ql-active {
    color: #60a5fa !important;
}

.dark .ql-toolbar .ql-fill {
    fill: #d1d5db !important;
}

/* Corrector ortográfico */
[spellcheck="true"] {
    outline: none;
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
</style>
@endsection

@section('content')
@php
    $hoy = date('Y-m-d');
@endphp

<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">✏️ Editar Actividad</h2>

        {{-- Alerta de corrector --}}
        <div class="mb-4 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center gap-2">
                <i class="ri-magic-line"></i>
                <span class="text-sm">✨ Corrector ortográfico activado - Las palabras con errores se subrayarán automáticamente</span>
            </div>
        </div>

        {{-- Alerta de validación --}}
        <div id="validation-alert" class="hidden mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800">
            <div class="flex items-start gap-3">
                <i class="ri-error-warning-line text-xl"></i>
                <div class="flex-1">
                    <h4 class="font-bold mb-2">⚠️ Campos incompletos</h4>
                    <p class="text-sm mb-2">Por favor, completa los siguientes campos obligatorios:</p>
                    <ul id="error-list" class="text-sm space-y-1 list-disc list-inside"></ul>
                </div>
                <button onclick="document.getElementById('validation-alert').classList.add('hidden')" 
                        class="text-red-500 hover:text-red-700">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>
        </div>

        <form id="activityForm" action="{{ route('actividades.update', $actividad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text" name="titulo" id="titulo"
                       value="{{ old('titulo', $actividad->titulo) }}"
                       spellcheck="true" lang="es" required
                       class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                       data-required="Título">
            </div>

            {{-- Autor y Fecha --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="autor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Autor <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="autor" id="autor"
                           value="{{ old('autor', $actividad->autor) }}"
                           spellcheck="true" lang="es" required
                           class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                           data-required="Autor">
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Fecha <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="fecha" id="fecha" max="{{ $hoy }}"
                           value="{{ old('fecha', $actividad->fecha) }}" required
                           class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                           data-required="Fecha">
                </div>
            </div>

            {{-- Área --}}
            <div>
                <label for="tipo_area" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Área <span class="text-red-500">*</span>
                </label>
                <select name="tipo_area" id="tipo_area" required
                        class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                        data-required="Área">
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

            {{-- Resumen --}}
            <div>
                <label for="resumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Resumen</label>
                <div id="resumen-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="resumen" id="resumen-content" class="hidden">{{ old('resumen', $actividad->resumen) }}</textarea>
            </div>

            {{-- Presupuesto y Tipo --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="presupuesto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto" step="0.01"
                           value="{{ old('presupuesto', $actividad->presupuesto) }}"
                           class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                </div>

                <div>
                    <label for="tipo_presupuesto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Presupuesto</label>
                    <select name="tipo_presupuesto" id="tipo_presupuesto"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
                        <option value="">Seleccionar</option>
                        <option value="Municipal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Municipal' ? 'selected' : '' }}>Municipal</option>
                        <option value="Estatal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Estatal' ? 'selected' : '' }}>Estatal</option>
                        <option value="Federal" {{ old('tipo_presupuesto', $actividad->tipo_presupuesto) == 'Federal' ? 'selected' : '' }}>Federal</option>
                    </select>
                </div>
            </div>

            {{-- Contenido --}}
            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenido</label>
                <div id="contenido-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="contenido" id="contenido-content" class="hidden">{{ old('contenido', $actividad->contenido) }}</textarea>
            </div>

            {{-- Foto --}}
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-600 dark:file:text-gray-200 dark:hover:file:bg-gray-500">
                
                @if($actividad->foto)
                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto actual:</p>
                        <img src="{{ asset('storage/' . $actividad->foto) }}" alt="Foto actual"
                             class="w-48 h-32 object-cover rounded-lg shadow-md border-2 border-gray-200 dark:border-gray-600">
                    </div>
                @endif
            </div>

            {{-- Botones --}}
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
let quillResumen, quillContenido;

document.addEventListener('DOMContentLoaded', function () {
    // Configuración de Quill
    const Font = Quill.import('formats/font');
    Font.whitelist = ['arial', 'times', 'georgia', 'verdana'];
    Quill.register(Font, true);

    const toolbarOptions = [
        [{ 'font': ['arial', 'times', 'georgia', 'verdana'] }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'header': [1, 2, 3, false] }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'align': [] }],
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

    // Inicializar editor Resumen
    const resumenHidden = document.getElementById('resumen-content');
    if (document.getElementById('resumen-editor') && resumenHidden) {
        quillResumen = new Quill('#resumen-editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });
        
        if (resumenHidden.value) {
            quillResumen.root.innerHTML = resumenHidden.value;
        }
        
        quillResumen.on('text-change', () => {
            resumenHidden.value = quillResumen.root.innerHTML;
        });
    }

    // Inicializar editor Contenido
    const contenidoHidden = document.getElementById('contenido-content');
    if (document.getElementById('contenido-editor') && contenidoHidden) {
        quillContenido = new Quill('#contenido-editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });
        
        if (contenidoHidden.value) {
            quillContenido.root.innerHTML = contenidoHidden.value;
        }
        
        quillContenido.on('text-change', () => {
            contenidoHidden.value = quillContenido.root.innerHTML;
        });
    }

    traducir();

    // Validación del formulario
    const form = document.getElementById('activityForm');
    const validationAlert = document.getElementById('validation-alert');
    const errorList = document.getElementById('error-list');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const errors = [];
        
        // Validar campos requeridos
        const requiredFields = form.querySelectorAll('[data-required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                errors.push(field.getAttribute('data-required'));
                field.classList.add('border-red-500', 'dark:border-red-500');
            } else {
                field.classList.remove('border-red-500', 'dark:border-red-500');
            }
        });

        // Validar Resumen (Quill)
        if (quillResumen && quillResumen.getText().trim().length === 0) {
            errors.push('Resumen');
            document.getElementById('resumen-editor').classList.add('border-red-500', 'dark:border-red-500');
        } else if (quillResumen) {
            document.getElementById('resumen-editor').classList.remove('border-red-500', 'dark:border-red-500');
        }

        // Validar Contenido (Quill)
        if (quillContenido && quillContenido.getText().trim().length === 0) {
            errors.push('Contenido');
            document.getElementById('contenido-editor').classList.add('border-red-500', 'dark:border-red-500');
        } else if (quillContenido) {
            document.getElementById('contenido-editor').classList.remove('border-red-500', 'dark:border-red-500');
        }

        if (errors.length > 0) {
            // Mostrar alerta
            validationAlert.classList.remove('hidden');
            errorList.innerHTML = '';
            errors.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorList.appendChild(li);
            });

            // Scroll a la alerta
            validationAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            return false;
        } else {
            // Ocultar alerta y enviar formulario
            validationAlert.classList.add('hidden');
            
            // Actualizar contenido de editores antes de enviar
            if (quillResumen) {
                document.getElementById('resumen-content').value = quillResumen.root.innerHTML;
            }
            if (quillContenido) {
                document.getElementById('contenido-content').value = quillContenido.root.innerHTML;
            }
            
            form.submit();
        }
    });
});
</script>
@endsection