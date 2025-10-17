@extends('layouts.master')

@section('title', 'Generar Informe')

@section('css')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    // Configurar Tailwind para usar clase manual
    tailwind.config = {
        darkMode: 'class',
    }
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/flowbite@1.8.1/dist/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<style>
  [x-cloak] { display: none !important; }
  .preview-container { display:flex; gap:.5rem; flex-wrap:wrap; margin-top:.5rem; }
  .preview-image-container { 
    position:relative; 
    width:300px; 
    height:200px; 
    border:1px solid #e5e7eb; 
    border-radius:.5rem; 
    overflow:hidden; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
  }
  .dark .preview-image-container {
    border-color: #374151;
  }
  .preview-image { width:100%; height:100%; object-fit:cover; border-radius:.5rem; }
  .remove-image-btn { 
    position:absolute; 
    top:8px; 
    right:8px; 
    background:rgba(239, 68, 68, 0.95); 
    color:white; 
    border-radius:9999px; 
    width:32px; 
    height:32px; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    border:2px solid white; 
    cursor:pointer; 
    font-size:16px;
    font-weight:bold;
    transition:all 0.2s;
    z-index:10;
  }
  .remove-image-btn:hover {
    background:rgba(220, 38, 38, 1);
    transform:scale(1.1);
  }
  .upload-box { 
    cursor:pointer; 
    border:2px dashed #cbd5e1; 
    padding:1rem; 
    border-radius:.5rem; 
    display:flex; 
    align-items:center; 
    justify-content:center; 
    text-align:center; 
    transition:all 0.2s; 
  }
  .dark .upload-box {
    border-color: #4b5563;
    background-color: #1f2937;
  }
  .upload-box.dragover { 
    border-color:#22c55e; 
    background:#f0fff4; 
  }
  .dark .upload-box.dragover {
    background:#064e3b;
  }
  .is-invalid { border-color: #ef4444 !important; } 
  @keyframes progress {
    from { width: 100%; }
    to { width: 0%; }
  }
  .animate-progress {
    animation: progress 5s linear;
  }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-2 pb-6 bg-white dark:bg-gray-800 rounded-2xl shadow" x-data="tabsForm()">

    <!-- Encabezado con título e ícono -->
    <div class="bg-gradient-to-r from-[#00713D] to-[#05924a] dark:from-green-800 dark:to-green-900 rounded-xl p-4 mb-3 shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-white mb-2">Formulario de Generación de Informe</h1>
                <p class="text-green-100 dark:text-green-200 text-sm">Complete la información requerida para generar el informe municipal</p>
            </div>
            <div class="flex-shrink-0 ml-6">
                <div class="w-24 h-24 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center shadow-xl border-4 border-green-200 dark:border-green-600">
                    <svg class="w-16 h-16 text-[#00713D] dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast de Error -->
    <div x-show="showError" 
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         class="fixed top-6 right-6 max-w-md bg-gradient-to-r from-red-600 to-red-700 dark:from-red-800 dark:to-red-900 text-white rounded-xl shadow-2xl overflow-hidden z-50"
         x-cloak>
        <div class="relative">
            <div class="absolute top-0 left-0 h-1 bg-red-400 dark:bg-red-500 animate-pulse w-full"></div>
            
            <div class="p-5">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-lg font-bold mb-2 flex items-center gap-2">
                            ⚠️ Campos Incompletos
                        </h3>
                        <p class="text-sm text-red-100 dark:text-red-200 mb-3">
                            Completa los siguientes campos:
                        </p>
                        <ul class="space-y-1.5">
                            <template x-for="(msg, index) in errorMessages" :key="index">
                                <li class="text-sm text-white flex items-center gap-2 bg-white/10 rounded-lg px-3 py-2 backdrop-blur-sm">
                                    <span class="text-red-300 dark:text-red-400">→</span>
                                    <span x-text="msg"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    
                    <button @click="showError = false" 
                            class="flex-shrink-0 text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="h-1 bg-red-800 dark:bg-red-950">
                <div class="h-full bg-red-300 dark:bg-red-500 animate-progress"></div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <nav class="mb-6 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex gap-6 text-sm text-gray-600 dark:text-gray-400">
            <li><button @click="current='inicio'" :class="current==='inicio' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Inicio</button></li>
            <li><button @click="current='informacion'" :class="current==='informacion' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Información Municipio</button></li>
            <li><button @click="current='introduccion'" :class="current==='introduccion' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Introducción</button></li>
            <li><button @click="current='gobierno'" :class="current==='gobierno' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Introducción Gobierno</button></li>
            <li><button @click="current='actividades'" :class="current==='actividades' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Actividades</button></li>
        </ul>
    </nav>

    <form id="informeForm" method="POST" action="{{ route('informes.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- INICIO -->
        <section x-show="current==='inicio'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Portada</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div x-data="inputField('Título del Informe')" class="mb-4 w-full">
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Título del Informe</label>
                <input 
                    type="text" 
                    name="titulo"
                    autocomplete="off"
                    x-model="value" 
                    @blur="validate()" 
                    placeholder="Ingrese el título del informe"
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-green-500 !bg-white dark:!bg-gray-700 !text-gray-900 dark:!text-gray-100"
                    :class="error ? 'border-red-500 focus:ring-red-500' : ''"
                >
                <p x-show="error" x-text="error" class="text-red-600 dark:text-red-400 text-sm mt-1"></p>
            </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Período</label>
                    <input type="text" id="periodo" name="periodo" class="w-full rounded-md border-gray-300 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Selecciona el período" required>
                </div>
            </div>

            <!-- INFORMACIÓN DE LA COMUNA -->
            <div x-data="{
                edit: false,
                presidenteNombre: 'C. JOSÉ LUIS ANTÚNEZ GOICOCHEA',
                presidenteCargo: 'Presidente Municipal Constitucional',
                sindicatoNombre: 'Profa. Maricela Cruz Cedillo',
                sindicatoCargo: 'Síndica Procuradora Municipal',
                secretarioNombre: 'C. Profr. Mario Alberto Lagunas Salgado',
                secretarioCargo: 'Secretario General del H. Ayuntamiento Municipal Constitucional',
                regidores: [
                    { nombre: 'C. Zenón Huerta Arellano', cargo: 'Desarrollo Urbano, Medio Ambiente y Obras Públicas' },
                    { nombre: 'C. Ma. del Carmen Barrera Galarza', cargo: 'Educación, Cultura, Recreación, Espectáculos y Juventud' },
                    { nombre: 'C. Arturo León Juan', cargo: 'Salud y Asistencia Social' },
                    { nombre: 'C. Ma. Isabel Quintana Gómez', cargo: 'Equidad y Género, Derecho de las Niñas y Adolescentes' },
                    { nombre: 'C. Jesús Javier Cruz', cargo: 'Desarrollo Rural, Participación Social de Migrantes' },
                    { nombre: 'C. Edith Aguirre Flores', cargo: 'Comercio, Abasto Popular, Atención y Fomento al Empleo' }
                ]
            }" class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg mb-8 border border-gray-200 dark:border-gray-700">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-extrabold text-[#00713D] dark:text-green-400">INFORMACIÓN DE LA COMUNA</h2>
                    <button type="button" @click="edit = !edit" 
                            class="px-3 py-1 text-sm rounded-lg font-medium"
                            :class="edit ? 'bg-red-500 dark:bg-red-600 text-white' : 'bg-green-500 dark:bg-green-600 text-white'">
                        <span x-text="edit ? 'Guardar' : 'Editar'"></span>
                    </button>
                </div>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="p-5 bg-green-50 dark:bg-gray-700 border border-green-200 dark:border-gray-600 rounded-xl shadow-sm hover:shadow-md transition">
                        <h3 class="text-xl font-bold text-[#00713D] dark:text-green-400 mb-3">Presidencia</h3>
                        <p x-show="!edit" class="text-lg text-gray-800 dark:text-gray-200 leading-relaxed">
                            <strong class="font-semibold text-gray-900 dark:text-white" x-text="presidenteNombre"></strong><br>
                            <span class="italic text-gray-600 dark:text-gray-400" x-text="presidenteCargo"></span>
                        </p>
                        <div x-show="edit" class="space-y-3">
                            <input type="text" name="presidenteNombre" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="presidenteNombre">
                            <input type="text" name="presidenteCargo" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="presidenteCargo">
                        </div>
                    </div>

                    <div class="p-5 bg-green-50 dark:bg-gray-700 border border-green-200 dark:border-gray-600 rounded-xl shadow-sm hover:shadow-md transition">
                        <h3 class="text-xl font-bold text-[#00713D] dark:text-green-400 mb-3">Sindicato</h3>
                        <p x-show="!edit" class="text-lg text-gray-800 dark:text-gray-200 leading-relaxed">
                            <strong class="font-semibold text-gray-900 dark:text-white" x-text="sindicatoNombre"></strong><br>
                            <span class="italic text-gray-600 dark:text-gray-400" x-text="sindicatoCargo"></span>
                        </p>
                        <div x-show="edit" class="space-y-3">
                            <input type="text" name="sindicatoNombre" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="sindicatoNombre">
                            <input type="text" name="sindicatoCargo" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="sindicatoCargo">
                        </div>
                    </div>

                    <div class="p-5 bg-green-50 dark:bg-gray-700 border border-green-200 dark:border-gray-600 rounded-xl shadow-sm hover:shadow-md transition">
                        <h3 class="text-xl font-bold text-[#00713D] dark:text-green-400 mb-3">Secretaría</h3>
                        <p x-show="!edit" class="text-lg text-gray-800 dark:text-gray-200 leading-relaxed">
                            <strong class="font-semibold text-gray-900 dark:text-white" x-text="secretarioNombre"></strong><br>
                            <span class="italic text-gray-600 dark:text-gray-400" x-text="secretarioCargo"></span>
                        </p>
                        <div x-show="edit" class="space-y-3">
                            <input type="text" name="secretarioNombre" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="secretarioNombre">
                            <input type="text" name="secretarioCargo" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="secretarioCargo">
                        </div>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-[#00713D] dark:text-green-400 mb-4">Regidores</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <template x-for="(regidor, index) in regidores" :key="index">
                        <div class="p-5 bg-green-50 dark:bg-gray-700 border border-green-200 dark:border-gray-600 rounded-xl shadow-sm hover:shadow-md transition">
                            <p x-show="!edit" class="text-lg text-gray-800 dark:text-gray-200 leading-relaxed">
                                <strong class="font-semibold text-gray-900 dark:text-white" x-text="regidor.nombre"></strong> – <span class="italic text-gray-600 dark:text-gray-400" x-text="regidor.cargo"></span>
                            </p>
                            <div x-show="edit" class="space-y-3">
                                <input type="text" :name="'regidor' + (index+1) + 'Nombre'" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="regidor.nombre">
                                <input type="text" :name="'regidor' + (index+1) + 'Cargo'" class="w-full border dark:border-gray-600 rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D] dark:focus:ring-green-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100" x-model="regidor.cargo">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Imagen Portada -->
            <div class="flex items-center justify-center w-full" id="upload-box-inicio">
                <label for="imagen-comuna-inicio" class="upload-box w-full">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 
                                   5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 
                                   5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="imagen-comuna-inicio" name="portada" type="file" class="hidden" />
                </label>
            </div>
            <div id="upload-preview" class="preview-container"></div>

            <div class="mt-6 flex justify-end">
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] dark:!bg-green-600 hover:bg-[#05924a] dark:hover:bg-green-700 transition">
                    Siguiente →
                </button>
            </div>
        </section>

<!-- INFORMACIÓN MUNICIPIO -->
        <section x-show="current==='informacion'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Información del Municipio</h2>

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Nombre del Municipio</label>
                <input 
                    type="text" 
                    name="municipio_nombre" 
                    autocomplete="off"
                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 !bg-white dark:!bg-gray-700 !text-gray-900 dark:!text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-green-500" 
                    placeholder="Nombre oficial del municipio" 
                    required
                >
            </div>

           <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Descripción del Municipio</label>
                <div id="municipio-descripcion-editor" class="border rounded-md min-h-[150px]"></div>
                <textarea name="municipio_descripcion" id="municipio-descripcion-content" class="hidden" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Imagen del Municipio</label>
                <div class="flex items-center justify-center w-full" id="upload-box-informacion">
                    <label for="imagen-comuna-informacion" class="upload-box w-full">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="imagen-comuna-informacion" name="municipio_imagen" type="file" class="hidden" />
                    </label>
                </div>
                <div id="informacion-preview" class="preview-container"></div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="prevTab()" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">← Anterior</button>
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] dark:!bg-green-600 hover:bg-[#05924a] dark:hover:bg-green-700 transition">Siguiente →</button>
            </div>
        </section>

        <!-- INTRODUCCIÓN -->
        <section x-show="current==='introduccion'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Introducción</h2>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Introducción</label>
            <div id="introduccion-editor" class="border rounded-md bg-white dark:bg-gray-700 min-h-[150px]"></div>
            <textarea name="introduccion" id="introduccion-content" class="hidden" required></textarea>
        </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Imagen para Introducción</label>
                <div class="flex items-center justify-center w-full" id="upload-box-introduccion">
                    <label for="imagen-introduccion" class="upload-box w-full">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="imagen-introduccion" name="introduccion_imagen" type="file" class="hidden" />
                    </label>
                </div>
                <div id="introduccion-preview" class="preview-container"></div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="prevTab()" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">← Anterior</button>
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] dark:!bg-green-600 hover:bg-[#05924a] dark:hover:bg-green-700 transition">Siguiente →</button>
            </div>
        </section>

        <!-- GOBIERNO -->
        <section x-show="current==='gobierno'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Introducción del Gobierno</h2>

           <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Contenido de la introducción del gobierno</label>
                <div id="gobierno-editor" class="border rounded-md bg-white dark:bg-gray-700 min-h-[150px]"></div>
                <textarea name="gobierno_introduccion" id="gobierno-content" class="hidden" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Imagen del Gobierno</label>
                <div class="flex items-center justify-center w-full" id="upload-box-gobierno">
                    <label for="imagen-gobierno" class="upload-box w-full">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="imagen-gobierno" name="gobierno_imagen" type="file" class="hidden" />
                    </label>
                </div>
                <div id="gobierno-preview" class="preview-container"></div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="prevTab()" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">← Anterior</button>
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] dark:!bg-green-600 hover:bg-[#05924a] dark:hover:bg-green-700 transition">Siguiente →</button>
            </div>
        </section>

        <!-- ACTIVIDADES -->
        <section x-show="current==='actividades'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Filtro de Actividades</h2>

            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    <strong>Nota:</strong> Las actividades se cargan automáticamente desde el módulo de gestión. 
                    Aquí solo defines el período y criterios de filtrado.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Fecha Inicio</label>
                    <input type="date" name="actividades_fecha_inicio" 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Fecha Fin</label>
                    <input type="date" name="actividades_fecha_fin" 
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Dependencias a Incluir</label>
                <select name="dependencias[]" multiple 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" 
                        size="8" required>
                    <option value="presidencia" class="dark:bg-gray-700">Despacho del Presidente Municipal</option>
                    <option value="sindicatura" class="dark:bg-gray-700">Sindicatura</option>
                    <option value="secretaria_general" class="dark:bg-gray-700">Secretaría General</option>
                    <option value="tesoreria" class="dark:bg-gray-700">Tesorería</option>
                    <option value="oficialia_mayor" class="dark:bg-gray-700">Oficialía Mayor</option>
                    <option value="catastro" class="dark:bg-gray-700">Catastro</option>
                    <option value="registro_civil" class="dark:bg-gray-700">Registro Civil</option>
                    <option value="transito" class="dark:bg-gray-700">Tránsito y Vialidad</option>
                    <option value="seguridad" class="dark:bg-gray-700">Seguridad Pública</option>
                    <option value="obras_publicas" class="dark:bg-gray-700">Obras Públicas</option>
                    <option value="dif" class="dark:bg-gray-700">DIF Municipal</option>
                    <option value="educacion" class="dark:bg-gray-700">Educación</option>
                    <option value="cultura" class="dark:bg-gray-700">Arte y Cultura</option>
                    <option value="salud" class="dark:bg-gray-700">Salud Pública</option>
                    <option value="limpia" class="dark:bg-gray-700">Limpia y Medio Ambiente</option>
                    <option value="proteccion_civil" class="dark:bg-gray-700">Protección Civil</option>
                    <option value="bienestar" class="dark:bg-gray-700">Bienestar Social</option>
                    <option value="desarrollo_rural" class="dark:bg-gray-700">Desarrollo Rural</option>
                    <option value="turismo" class="dark:bg-gray-700">Turismo</option>
                    <option value="deporte" class="dark:bg-gray-700">Deporte</option>
                </select>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mantén presionado Ctrl/Cmd para seleccionar múltiples</p>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="prevTab()" 
                        class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    ← Anterior
                </button>
                <button type="submit" 
                        class="px-4 py-2 rounded text-white !bg-[#00713D] dark:!bg-green-600 hover:bg-[#05924a] dark:hover:bg-green-700 transition">
                    Generar Informe
                </button>
            </div>
        </section>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

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

/* Editor - Dark Mode Compatible */
.ql-toolbar.ql-snow {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem 0.5rem 0 0;
    background: #f9fafb;
}

.dark .ql-toolbar.ql-snow {
    border-color: #4b5563;
    background: #374151;
}

.ql-container.ql-snow {
    border: 1px solid #d1d5db;
    border-top: none;
    border-radius: 0 0 0.5rem 0.5rem;
    min-height: 200px;
}

.dark .ql-container.ql-snow {
    border-color: #4b5563;
    background: #1f2937;
}

.ql-editor {
    min-height: 200px;
    padding: 15px;
    color: #111827;
}

.dark .ql-editor {
    color: #f3f4f6;
}

.ql-toolbar button:hover { color: #00713D !important; }
.ql-toolbar button.ql-active { color: #00713D !important; }

.dark .ql-toolbar button {
    color: #d1d5db !important;
}

.dark .ql-toolbar button:hover { 
    color: #22c55e !important; 
}

.dark .ql-toolbar button.ql-active { 
    color: #22c55e !important; 
}

.dark .ql-stroke {
    stroke: #d1d5db !important;
}

.dark .ql-fill {
    fill: #d1d5db !important;
}

.dark .ql-picker-label {
    color: #d1d5db !important;
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

/* Dropdown dark mode */
.dark .ql-picker-options {
    background-color: #374151 !important;
    border-color: #4b5563 !important;
}

.dark .ql-picker-item {
    color: #d1d5db !important;
}

.dark .ql-picker-item:hover {
    color: #22c55e !important;
}
</style>

<script>
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

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const editores = [
            { id: 'introduccion-editor', hidden: 'introduccion-content' },
            { id: 'municipio-descripcion-editor', hidden: 'municipio-descripcion-content' },
            { id: 'gobierno-editor', hidden: 'gobierno-content' }
        ];

        const quillEditors = {};
        
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
                
                quillEditors[cfg.id] = quill;
            }
        });

        window.quillEditors = quillEditors;
        traducir();
    }, 100);
});

document.addEventListener('alpine:init', () => {
    // Componente para validación de inputs
    Alpine.data('inputField', (label) => ({
        value: '',
        error: '',
        validate() {
            if (!this.value.trim()) {
                this.error = `El campo ${label} es obligatorio`;
            } else {
                this.error = '';
            }
        }
    }));

    // Componente principal del formulario
    Alpine.data('tabsForm', () => ({
        current: 'inicio',
        tabs: ['inicio', 'informacion', 'introduccion', 'gobierno', 'actividades'],
        showError: false,
        errorMessages: [],
        
        showToast(msgs) {
            this.errorMessages = msgs;
            this.showError = true;
            setTimeout(() => this.showError = false, 5000);
        },
        
        validateTab() {
            const missing = [];
            
            if (this.current === 'inicio') {
                if (!document.querySelector('input[name="titulo"]')?.value.trim()) missing.push('Título');
                if (!document.querySelector('input[name="periodo"]')?.value.trim()) missing.push('Período');
                if (!document.querySelector('#upload-preview')?.children.length) missing.push('Imagen Portada');
            }
            
            if (this.current === 'informacion') {
                if (!document.querySelector('input[name="municipio_nombre"]')?.value.trim()) missing.push('Nombre Municipio');
                if (!window.quillEditors?.['municipio-descripcion-editor'] || 
                    window.quillEditors['municipio-descripcion-editor'].getText().trim().length === 0) {
                    missing.push('Descripción del Municipio');
                }
                if (!document.querySelector('#informacion-preview')?.children.length) missing.push('Imagen del Municipio');
            }
            
            if (this.current === 'introduccion') {
                if (!window.quillEditors?.['introduccion-editor'] || 
                    window.quillEditors['introduccion-editor'].getText().trim().length === 0) {
                    missing.push('Contenido de Introducción');
                }
                if (!document.querySelector('#introduccion-preview')?.children.length) missing.push('Imagen de Introducción');
            }
            
            if (this.current === 'gobierno') {
                if (!window.quillEditors?.['gobierno-editor'] || 
                    window.quillEditors['gobierno-editor'].getText().trim().length === 0) {
                    missing.push('Contenido de Gobierno');
                }
                if (!document.querySelector('#gobierno-preview')?.children.length) missing.push('Imagen de Gobierno');
            }
            
            if (this.current === 'actividades') {
                const fechaInicio = document.querySelector('input[name="actividades_fecha_inicio"]')?.value;
                const fechaFin = document.querySelector('input[name="actividades_fecha_fin"]')?.value;
                const dependencias = document.querySelector('select[name="dependencias[]"]')?.selectedOptions;
                
                if (!fechaInicio) missing.push('Fecha de Inicio');
                if (!fechaFin) missing.push('Fecha de Fin');
                if (!dependencias || dependencias.length === 0) missing.push('Al menos una dependencia');
            }
            
            if (missing.length > 0) {
                this.showToast(missing);
                return false;
            }
            return true;
        },
        
        nextTab() {
            if (this.validateTab()) {
                const i = this.tabs.indexOf(this.current);
                if (i < this.tabs.length - 1) this.current = this.tabs[i + 1];
            }
        },
        
        prevTab() {
            const i = this.tabs.indexOf(this.current);
            if (i > 0) this.current = this.tabs[i - 1];
        }
    }));
});

// Flatpickr para selector de período
flatpickr("#periodo", {
    dateFormat: "d-m-Y",
    defaultDate: new Date(),
    locale: "es"
});

// Función mejorada para preview de imágenes con eliminación
function setupPreview(inputId, containerId, uploadBoxId, min = 1) {
    const input = document.getElementById(inputId);
    const container = document.getElementById(containerId);
    const box = document.getElementById(uploadBoxId);
    
    if (!input || !container || !box) return;
    
    input.addEventListener('change', function() {
        container.innerHTML = '';
        
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.classList.add('preview-image-container');
                div.innerHTML = `
                    <img src="${e.target.result}" class="preview-image" alt="Vista previa" />
                    <button type="button" class="remove-image-btn" onclick="removeImage('${inputId}', '${containerId}', '${uploadBoxId}', ${index})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
        
        box.style.display = this.files.length >= min ? 'none' : 'flex';
    });
}

// Función para eliminar una imagen específica
function removeImage(inputId, containerId, uploadBoxId, imageIndex) {
    const input = document.getElementById(inputId);
    const container = document.getElementById(containerId);
    const box = document.getElementById(uploadBoxId);
    
    if (!input || !container || !box) return;
    
    // Crear nuevo DataTransfer sin el archivo eliminado
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    files.forEach((file, index) => {
        if (index !== imageIndex) {
            dt.items.add(file);
        }
    });
    
    // Actualizar el input
    input.files = dt.files;
    
    // Limpiar y regenerar previews
    container.innerHTML = '';
    
    Array.from(dt.files).forEach((file, newIndex) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.classList.add('preview-image-container');
            div.innerHTML = `
                <img src="${e.target.result}" class="preview-image" alt="Vista previa" />
                <button type="button" class="remove-image-btn" onclick="removeImage('${inputId}', '${containerId}', '${uploadBoxId}', ${newIndex})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    // Mostrar u ocultar el box de carga
    box.style.display = dt.files.length > 0 ? 'none' : 'flex';
}

// Configurar previews para cada sección
setupPreview('imagen-comuna-inicio', 'upload-preview', 'upload-box-inicio');
setupPreview('imagen-comuna-informacion', 'informacion-preview', 'upload-box-informacion');
setupPreview('imagen-introduccion', 'introduccion-preview', 'upload-box-introduccion');
setupPreview('imagen-gobierno', 'gobierno-preview', 'upload-box-gobierno');
</script>
@endsection