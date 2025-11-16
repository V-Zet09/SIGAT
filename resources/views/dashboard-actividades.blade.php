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

/* Inputs en modo oscuro - FIX para color de texto */
input[type="text"],
input[type="date"],
input[type="number"],
select,
textarea {
    color-scheme: dark;
}

.dark input[type="text"],
.dark input[type="date"],
.dark input[type="number"],
.dark select,
.dark textarea {
    color: #e5e7eb !important;
}

.dark input[type="text"]::placeholder,
.dark textarea::placeholder {
    color: #6b7280;
}

/* Fix específico para Chrome en modo oscuro */
.dark input:-webkit-autofill,
.dark input:-webkit-autofill:hover,
.dark input:-webkit-autofill:focus {
    -webkit-text-fill-color: #e5e7eb !important;
    -webkit-box-shadow: 0 0 0px 1000px #374151 inset !important;
    transition: background-color 5000s ease-in-out 0s;
}
</style>
@endsection

@section('content')
@php
    $hoy = date('Y-m-d');
@endphp

<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">📌 Registrar Nueva Actividad</h2>

        {{-- Alerta visual para fecha inválida --}}
        <div id="alerta-fecha" class="hidden mb-4 p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 border border-yellow-300 dark:border-yellow-700">
            ⚠️ No puedes registrar una actividad con fecha futura.
        </div>

        <form action="{{ route('actividades.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Título --}}
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título</label>
                <input type="text" name="titulo" id="titulo"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                       required>
            </div>

            {{-- Autor + Fecha --}}
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

            {{-- Área --}}
            <div>
                <label for="tipo_area" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Área</label>
                <select name="tipo_area" id="tipo_area"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
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
                <label for="resumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Resumen</label>
                <div id="resumen-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="resumen" id="resumen-content" class="hidden"></textarea>
            </div>

            {{-- Presupuesto + Tipo Presupuesto --}}
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

            {{-- Contenido --}}
            <div>
                <label for="contenido" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenido</label>
                <div id="contenido-editor" class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700"></div>
                <textarea name="contenido" id="contenido-content" class="hidden"></textarea>
            </div>

            {{-- Foto --}}
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto</label>
                <input type="file" name="foto[]" id="foto" multiple
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-600 dark:file:text-gray-200 dark:hover:file:bg-gray-500">
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('actividades.registradas') }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">Cancelar</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition">
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

        // Inicializar editores
        const editores = [
            { id: 'resumen-editor', hidden: 'resumen-content' },
            { id: 'contenido-editor', hidden: 'contenido-content' }
        ];

        editores.forEach(cfg => {
            const el = document.getElementById(cfg.id);
            if (el) {
                const quill = new Quill(`#${cfg.id}`, {
                    theme: 'snow',
                    modules: { toolbar: toolbarOptions }
                });
                
                quill.on('text-change', () => {
                    document.getElementById(cfg.hidden).value = quill.root.innerHTML;
                });
            }
        });

        traducir();
    });
</script>
@endsection