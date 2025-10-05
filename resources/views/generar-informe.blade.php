@extends('layouts.master')

@section('title', 'Generar Informe')

@section('css')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/flowbite@1.8.1/dist/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<style>
  [x-cloak] { display: none !important; }
  .preview-container { display:flex; gap:.5rem; flex-wrap:wrap; margin-top:.5rem; }
  .preview-image-container { position:relative; width:300px; height:200px; border:1px solid #e5e7eb; border-radius:.5rem; overflow:hidden; display:flex; align-items:center; justify-content:center; }
  .preview-image { width:100%; height:100%; object-fit:cover; border-radius:.5rem; }
  .remove-image-btn { position:absolute; top:4px; right:4px; background:rgba(0,0,0,.6); color:white; border-radius:9999px; width:28px; height:28px; display:flex; align-items:center; justify-content:center; border:none; cursor:pointer; font-size:18px; }
  .upload-box { cursor:pointer; border:2px dashed #cbd5e1; padding:1rem; border-radius:.5rem; display:flex; align-items:center; justify-content:center; text-align:center; transition:all 0.2s; }
  .upload-box.dragover { border-color:#22c55e; background:#f0fff4; }
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
<div class="max-w-7xl mx-auto px-6 pt-2 pb-6 bg-white rounded-2xl shadow" x-data="tabsForm()">

    <!-- NUEVO: Encabezado con título e ícono -->
<div class="bg-gradient-to-r from-[#00713D] to-[#05924a] rounded-xl p-4 mb-3 shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-white mb-2">Formulario de Generación de Informe</h1>
                <p class="text-green-100 text-sm">Complete la información requerida para generar el informe municipal</p>
            </div>
            <div class="flex-shrink-0 ml-6">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-xl border-4 border-green-200">
                    <svg class="w-16 h-16 text-[#00713D]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast de Error Mejorado -->
    <div x-show="showError" 
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         class="fixed top-6 right-6 max-w-md bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl shadow-2xl overflow-hidden z-50"
         x-cloak>
        <div class="relative">
            <!-- Barra animada superior -->
            <div class="absolute top-0 left-0 h-1 bg-red-400 animate-pulse w-full"></div>
            
            <div class="p-5">
                <div class="flex items-start gap-4">
                    <!-- Icono -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Contenido -->
                    <div class="flex-1">
                        <h3 class="text-lg font-bold mb-2 flex items-center gap-2">
                            ⚠️ Campos Incompletos
                        </h3>
                        <p class="text-sm text-red-100 mb-3">
                            Completa los siguientes campos:
                        </p>
                        <ul class="space-y-1.5">
                            <template x-for="(msg, index) in errorMessages" :key="index">
                                <li class="text-sm text-white flex items-center gap-2 bg-white/10 rounded-lg px-3 py-2 backdrop-blur-sm">
                                    <span class="text-red-300">→</span>
                                    <span x-text="msg"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    
                    <!-- Botón cerrar -->
                    <button @click="showError = false" 
                            class="flex-shrink-0 text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Barra de progreso -->
            <div class="h-1 bg-red-800">
                <div class="h-full bg-red-300 animate-progress"></div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <nav class="mb-6 border-b border-gray-200">
        <ul class="flex gap-6 text-sm text-gray-600">
            <li><button @click="current='inicio'" :class="current==='inicio' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Inicio</button></li>
            <li><button @click="current='informacion'" :class="current==='informacion' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Información Municipio</button></li>
            <li><button @click="current='introduccion'" :class="current==='introduccion' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Introducción</button></li>
            <li><button @click="current='gobierno'" :class="current==='gobierno' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Introducción Gobierno</button></li>
            <li><button @click="current='actividades'" :class="current==='actividades' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Actividades</button></li>
        </ul>
    </nav>

    <form id="informeForm" method="POST" action="{{ route('informes.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- INICIO -->
        <section x-show="current==='inicio'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Portada</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div x-data="inputField('Título del Informe')" class="mb-4 w-full">
                <label class="block text-sm font-medium mb-1">Título del Informe</label>
                <input 
                    type="text" 
                    name="titulo"
                    x-model="value" 
                    @blur="validate()" 
                    placeholder="Ingrese el título del informe"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    :class="error ? 'border-red-500 focus:ring-red-500' : ''"
                >
                <p x-show="error" x-text="error" class="text-red-600 text-sm mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Período</label>
                    <input type="text" id="periodo" name="periodo" class="w-full rounded-md border-gray-300 px-3 py-2" placeholder="Selecciona el período" required>
                </div>
            </div>

            <!-- Sección INFORMACIÓN DE LA COMUNA -->
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
            }" class="bg-white p-8 rounded-2xl shadow-lg mb-8 border border-gray-200">

                <!-- Título y botón -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-extrabold text-[#00713D]">INFORMACIÓN DE LA COMUNA</h2>
                    <button type="button" @click="edit = !edit" 
                            class="px-3 py-1 text-sm rounded-lg font-medium"
                            :class="edit ? 'bg-red-500 text-white' : 'bg-green-500 text-white'">
                        <span x-text="edit ? 'Guardar' : 'Editar'"></span>
                    </button>
                </div>

                <!-- Presidencia / Sindicato / Secretaría -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="p-5 bg-green-50 border border-green-200 rounded-xl shadow-sm hover:shadow-md transition">
                        <h3 class="text-xl font-bold text-[#00713D] mb-3">Presidencia</h3>
                        <p x-show="!edit" class="text-lg text-gray-800 leading-relaxed">
                            <strong class="font-semibold text-gray-900" x-text="presidenteNombre"></strong><br>
                            <span class="italic text-gray-600" x-text="presidenteCargo"></span>
                        </p>
                        <div x-show="edit" class="space-y-3">
                            <input type="text" name="presidenteNombre" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="presidenteNombre">
                            <input type="text" name="presidenteCargo" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="presidenteCargo">
                        </div>
                    </div>

                    <div class="p-5 bg-green-50 border border-green-200 rounded-xl shadow-sm hover:shadow-md transition">
                        <h3 class="text-xl font-bold text-[#00713D] mb-3">Sindicato</h3>
                        <p x-show="!edit" class="text-lg text-gray-800 leading-relaxed">
                            <strong class="font-semibold text-gray-900" x-text="sindicatoNombre"></strong><br>
                            <span class="italic text-gray-600" x-text="sindicatoCargo"></span>
                        </p>
                        <div x-show="edit" class="space-y-3">
                            <input type="text" name="sindicatoNombre" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="sindicatoNombre">
                            <input type="text" name="sindicatoCargo" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="sindicatoCargo">
                        </div>
                    </div>

                    <div class="p-5 bg-green-50 border border-green-200 rounded-xl shadow-sm hover:shadow-md transition">
                        <h3 class="text-xl font-bold text-[#00713D] mb-3">Secretaría</h3>
                        <p x-show="!edit" class="text-lg text-gray-800 leading-relaxed">
                            <strong class="font-semibold text-gray-900" x-text="secretarioNombre"></strong><br>
                            <span class="italic text-gray-600" x-text="secretarioCargo"></span>
                        </p>
                        <div x-show="edit" class="space-y-3">
                            <input type="text" name="secretarioNombre" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="secretarioNombre">
                            <input type="text" name="secretarioCargo" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="secretarioCargo">
                        </div>
                    </div>
                </div>

                <!-- Regidores -->
                <h3 class="text-2xl font-bold text-[#00713D] mb-4">Regidores</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <template x-for="(regidor, index) in regidores" :key="index">
                        <div class="p-5 bg-green-50 border border-green-200 rounded-xl shadow-sm hover:shadow-md transition">
                            <p x-show="!edit" class="text-lg text-gray-800 leading-relaxed">
                                <strong class="font-semibold text-gray-900" x-text="regidor.nombre"></strong> – <span class="italic text-gray-600" x-text="regidor.cargo"></span>
                            </p>
                            <div x-show="edit" class="space-y-3">
                                <input type="text" :name="'regidor' + (index+1) + 'Nombre'" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="regidor.nombre">
                                <input type="text" :name="'regidor' + (index+1) + 'Cargo'" class="w-full border rounded-lg p-3 text-lg focus:ring-2 focus:ring-[#00713D]" x-model="regidor.cargo">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Imagen Portada -->
            <div class="flex items-center justify-center w-full" id="upload-box-inicio">
                <label for="imagen-comuna-inicio" class="upload-box w-full">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 
                                   5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 
                                   5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                        <p class="text-xs text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="imagen-comuna-inicio" name="portada" type="file" class="hidden" />
                </label>
            </div>
            <div id="upload-preview" class="preview-container"></div>

            <div class="mt-6 flex justify-end">
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:bg-[#05924a] transition">
                    Siguiente →
                </button>
            </div>
        </section>

        <!-- INFORMACIÓN MUNICIPIO -->
        <section x-show="current==='informacion'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Información del Municipio</h2>

            <div>
                <label class="block text-sm font-medium mb-1">Nombre del Municipio</label>
                <input type="text" name="municipio_nombre" class="w-full rounded-md border-gray-300 px-3 py-2" placeholder="Nombre oficial del municipio" required>
            </div>

           <div>
                <label class="block text-sm font-medium mb-1">Descripción del Municipio</label>
                <div id="municipio-descripcion-editor" class="border rounded-md bg-white min-h-[150px]"></div>
                <textarea name="municipio_descripcion" id="municipio-descripcion-content" class="hidden" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Imagen del Municipio</label>
                <div class="flex items-center justify-center w-full" id="upload-box-informacion">
                    <label for="imagen-comuna-informacion" class="upload-box w-full">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="imagen-comuna-informacion" name="municipio_imagen" type="file" class="hidden" />
                    </label>
                </div>
                <div id="informacion-preview" class="preview-container"></div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="prevTab()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition">← Anterior</button>
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:bg-[#05924a] transition">Siguiente →</button>
            </div>
        </section>

        <!-- INTRODUCCIÓN -->
        <section x-show="current==='introduccion'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Introducción</h2>

        <div>
            <label class="block text-sm font-medium mb-1">Introducción</label>
            <div id="introduccion-editor" class="border rounded-md bg-white min-h-[150px]"></div>
            <textarea name="introduccion" id="introduccion-content" class="hidden" required></textarea>
        </div>

            <div>
                <label class="block text-sm font-medium mb-1">Imagen para Introducción</label>
                <div class="flex items-center justify-center w-full" id="upload-box-introduccion">
                    <label for="imagen-introduccion" class="upload-box w-full">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="imagen-introduccion" name="introduccion_imagen" type="file" class="hidden" />
                    </label>
                </div>
                <div id="introduccion-preview" class="preview-container"></div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="prevTab()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition">← Anterior</button>
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:bg-[#05924a] transition">Siguiente →</button>
            </div>
        </section>

        <!-- GOBIERNO -->
        <section x-show="current==='gobierno'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Introducción del Gobierno</h2>

           <div>
                <label class="block text-sm font-medium mb-1">Contenido de la introducción del gobierno</label>
                <div id="gobierno-editor" class="border rounded-md bg-white min-h-[150px]"></div>
                <textarea name="gobierno_introduccion" id="gobierno-content" class="hidden" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Imagen del Gobierno</label>
                <div class="flex items-center justify-center w-full" id="upload-box-gobierno">
                    <label for="imagen-gobierno" class="upload-box w-full">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">CARGAR ARCHIVO</span> SUBIR IMAGEN</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="imagen-gobierno" name="gobierno_imagen" type="file" class="hidden" />
                    </label>
                </div>
                <div id="gobierno-preview" class="preview-container"></div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="prevTab()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition">← Anterior</button>
                <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:bg-[#05924a] transition">Siguiente →</button>
            </div>
        </section>

        <!-- ACTIVIDADES -->

<section x-show="current==='actividades'" x-cloak class="space-y-6">
    <h2 class="text-2xl font-bold text-[#00713D]">Filtro de Actividades</h2>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800">
            <strong>Nota:</strong> Las actividades se cargan automáticamente desde el módulo de gestión. 
            Aquí solo defines el período y criterios de filtrado.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Fecha Inicio</label>
            <input type="date" name="actividades_fecha_inicio" 
                   class="w-full rounded-md border-gray-300 px-3 py-2" required>
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1">Fecha Fin</label>
            <input type="date" name="actividades_fecha_fin" 
                   class="w-full rounded-md border-gray-300 px-3 py-2" required>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Dependencias a Incluir</label>
        <select name="dependencias[]" multiple 
                class="w-full rounded-md border-gray-300 px-3 py-2" 
                size="8" required>
            <option value="presidencia">Despacho del Presidente Municipal</option>
            <option value="sindicatura">Sindicatura</option>
            <option value="secretaria_general">Secretaría General</option>
            <option value="tesoreria">Tesorería</option>
            <option value="oficialia_mayor">Oficialía Mayor</option>
            <option value="catastro">Catastro</option>
            <option value="registro_civil">Registro Civil</option>
            <option value="transito">Tránsito y Vialidad</option>
            <option value="seguridad">Seguridad Pública</option>
            <option value="obras_publicas">Obras Públicas</option>
            <option value="dif">DIF Municipal</option>
            <option value="educacion">Educación</option>
            <option value="cultura">Arte y Cultura</option>
            <option value="salud">Salud Pública</option>
            <option value="limpia">Limpia y Medio Ambiente</option>
            <option value="proteccion_civil">Protección Civil</option>
            <option value="bienestar">Bienestar Social</option>
            <option value="desarrollo_rural">Desarrollo Rural</option>
            <option value="turismo">Turismo</option>
            <option value="deporte">Deporte</option>
        </select>
        <p class="text-xs text-gray-500 mt-1">Mantén presionado Ctrl/Cmd para seleccionar múltiples</p>
    </div>

    <div class="flex justify-between mt-4">
        <button type="button" @click="prevTab()" 
                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 transition">
            ← Anterior
        </button>
        <button type="submit" 
                class="px-4 py-2 rounded text-white !bg-[#00713D] hover:bg-[#05924a] transition">
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

/* Editor */
.ql-toolbar.ql-snow {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem 0.5rem 0 0;
    background: #f9fafb;
}

.ql-container.ql-snow {
    border: 1px solid #d1d5db;
    border-top: none;
    border-radius: 0 0 0.5rem 0.5rem;
    min-height: 200px;
}

.ql-editor {
    min-height: 200px;
    padding: 15px;
}

.ql-toolbar button:hover { color: #00713D !important; }
.ql-toolbar button.ql-active { color: #00713D !important; }

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

// Función para preview de imágenes
function setupPreview(inputId, containerId, uploadBoxId, min = 1) {
    const input = document.getElementById(inputId);
    const container = document.getElementById(containerId);
    const box = document.getElementById(uploadBoxId);
    
    if (!input || !container || !box) return;
    
    input.addEventListener('change', function() {
        container.innerHTML = '';
        
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.classList.add('preview-image-container');
                div.innerHTML = `<img src="${e.target.result}" class="preview-image" />`;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
        
        box.style.display = this.files.length >= min ? 'none' : 'flex';
    });
}

// Configurar previews para cada sección
setupPreview('imagen-comuna-inicio', 'upload-preview', 'upload-box-inicio');
setupPreview('imagen-comuna-informacion', 'informacion-preview', 'upload-box-informacion');
setupPreview('imagen-introduccion', 'introduccion-preview', 'upload-box-introduccion');
setupPreview('imagen-gobierno', 'gobierno-preview', 'upload-box-gobierno');
</script>
@endsection