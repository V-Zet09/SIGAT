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
<!-- Encabezado con título, ícono y botón -->
<div class="bg-gradient-to-r from-green-800 via-emerald-700 to-teal-700 rounded-2xl p-6 mb-3 shadow-lg">
    <div class="flex items-center justify-between">
        <!-- Sección izquierda: Ícono y textos -->
        <div class="flex items-center gap-4">
            <!-- Ícono con fondo semi-transparente oscuro -->
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-black/20">
                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
            
            
            <div>
                @php
                    $isEdit = isset($informe) && $informe !== null;
                @endphp
                
                <h1 class="text-3xl font-bold text-white">
                    {{ $isEdit ? 'Editar Informe' : 'Formulario de Generación de Informe' }}
                </h1>
                <p class="text-base text-white/80">
                    {{ $isEdit ? 'Modifica la información del informe existente' : 'Complete la información requerida para generar el informe municipal' }}
                </p>
            </div>
        </div>
        
        <!-- Botón Informes Generados -->
        <a href="{{ route('informes-generados') }}" 
           class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-base font-bold text-green-700 shadow-lg transition hover:bg-gray-50">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
            </svg>
            <span>Informes Generados</span>
        </a>
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
            <li><button @click="current='introduccion'" :class="current==='introduccion' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Introducción</button></li>
            <li><button @click="current='informacion'" :class="current==='informacion' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Información General del Municipio</button></li>
            <li><button @click="current='gobierno'" :class="current==='gobierno' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Gobierno y Desarrollo Municipal</button></li>
            <li><button @click="current='actividades'" :class="current==='actividades' ? 'text-[#00713D] dark:text-green-400 border-b-2 border-[#00713D] dark:border-green-400 pb-2' : 'pb-2 hover:text-gray-800 dark:hover:text-gray-300'" class="focus:outline-none">Actividades</button></li>
        </ul>
    </nav>


    <form id="informeForm" 
          method="POST" 
          action="{{ $isEdit ? route('informes.update', $informe->id) : route('informes.store') }}" 
          enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

<!-- INICIO -->
<section x-show="current==='inicio'" x-cloak class="space-y-6">
    <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Portada</h2>
    
    <!-- IMAGEN DE PORTADA (Nueva) -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl p-6">
        <div class="flex items-start gap-4 mb-4">
            <div class="flex-shrink-0">
                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-green-900 dark:text-green-300 mb-2">Imagen de Portada Principal</h3>
                <p class="text-sm text-green-700 dark:text-green-400">
                    Sube la imagen que aparecerá en la primera página del PDF generado. 
                    Se recomienda una imagen de alta calidad en formato vertical u horizontal.
                </p>
            </div>
        </div>
        
        <!-- ✅ CAMBIO 1: Agregar preview de imagen actual cuando editas -->
        @if($isEdit && isset($informe->portada_imagen_path) && $informe->portada_imagen_path)
            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-3 font-semibold">
                    <i class="fas fa-info-circle mr-1"></i> Imagen actual de portada:
                </p>
                <img src="{{ asset('storage/' . $informe->portada_imagen_path) }}" 
                     alt="Portada actual" 
                     class="max-w-md rounded-lg shadow-md border border-gray-300 dark:border-gray-600">
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 italic">
                    💡 Sube una nueva imagen para reemplazarla
                </p>
            </div>
        @endif
        
        <div class="flex items-center justify-center w-full" id="upload-box-portada-principal">
            <label for="portada-principal" class="upload-box w-full border-green-300 dark:border-green-700">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-12 h-12 mb-4 text-green-500 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="mb-2 text-base font-semibold text-green-700 dark:text-green-300">
                        {{ $isEdit ? 'CAMBIAR PORTADA' : 'CARGAR PORTADA' }}
                    </p>
                    <p class="text-sm text-green-600 dark:text-green-400">PNG, JPG o JPEG (Recomendado: Alta resolución)</p>
                    <p class="text-xs text-green-500 dark:text-green-500 mt-1">Arrastra o haz clic para seleccionar</p>
                </div>
                <!-- ✅ CAMBIO 2: Hacer opcional en edición -->
                <input id="portada-principal" name="portada_imagen" type="file" accept="image/png,image/jpeg,image/jpg" class="hidden" {{ $isEdit ? '' : 'required' }} />
            </label>
        </div>
        <div id="portada-principal-preview" class="preview-container"></div>
    </div>
    
    <!-- NUEVA SECCIÓN: PLANTILLA DE GOBIERNO -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-6 my-6">
        <div class="flex items-start gap-4 mb-4">
            <div class="flex-shrink-0">
                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-blue-900 dark:text-blue-300 mb-2">Plantilla del Gobierno</h3>
                <p class="text-sm text-blue-700 dark:text-blue-400">
                    Sube la plantilla oficial que los encargados elaboraron en Word (convertida a imagen). 
                    Esta se mostrará en el PDF generado.
                </p>
            </div>
        </div>

        <!-- ✅ Preview de plantilla actual -->
        @if($isEdit && isset($informe->plantilla_imagen_path) && $informe->plantilla_imagen_path)
            <div class="mb-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                <p class="text-sm text-purple-700 dark:text-purple-300 mb-3 font-semibold">
                    <i class="fas fa-info-circle mr-1"></i> Plantilla actual:
                </p>
                <img src="{{ asset('storage/' . $informe->plantilla_imagen_path) }}" 
                     alt="Plantilla actual" 
                     class="max-w-md rounded-lg shadow-md border border-gray-300 dark:border-gray-600">
                <p class="text-xs text-purple-600 dark:text-purple-400 mt-2 italic">
                    💡 Sube una nueva para reemplazarla o déjala vacía para mantener la actual
                </p>
            </div>
        @endif

        <div class="flex items-center justify-center w-full" id="upload-box-plantilla">
            <label for="plantilla-imagen" class="upload-box w-full border-blue-300 dark:border-blue-700">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-12 h-12 mb-4 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <p class="mb-2 text-base font-semibold text-blue-700 dark:text-blue-300">
                        {{ $isEdit ? 'CAMBIAR PLANTILLA' : 'CARGAR PLANTILLA OFICIAL' }}
                    </p>
                    <p class="text-sm text-blue-600 dark:text-blue-400">PNG, JPG o JPEG (Recomendado: Tamaño carta)</p>
                    <p class="text-xs text-blue-500 dark:text-blue-500 mt-1">Arrastra o haz clic para seleccionar</p>
                </div>
                <input id="plantilla-imagen" name="plantilla_imagen" type="file" accept="image/png,image/jpeg,image/jpg" class="hidden" />
            </label>
        </div>
        <div id="plantilla-preview" class="preview-container"></div>
    </div>

<!-- ✅ CAMBIO 3: INFORMACIÓN DE LA COMUNA - Cargar datos existentes -->
@php
$defaultRegidores = [
    ['nombre' => 'C. Zenón Huerta Arellano', 'cargo' => 'Desarrollo Urbano, Medio Ambiente y Obras Públicas'],
    ['nombre' => 'C. Ma. del Carmen Barrera Galarza', 'cargo' => 'Educación, Cultura, Recreación, Espectáculos y Juventud'],
    ['nombre' => 'C. Arturo León Juan', 'cargo' => 'Salud y Asistencia Social'],
    ['nombre' => 'C. Ma. Isabel Quintana Gómez', 'cargo' => 'Equidad y Género, Derecho de las Niñas y Adolescentes'],
    ['nombre' => 'C. Jesús Javier Cruz', 'cargo' => 'Desarrollo Rural, Participación Social de Migrantes'],
    ['nombre' => 'C. Edith Aguirre Flores', 'cargo' => 'Comercio, Abasto Popular, Atención y Fomento al Empleo']
];
@endphp

<div x-data="{
    edit: false,
    presidenteNombre: {{ json_encode(old('presidenteNombre', $informe->presidente_nombre ?? 'C. JOSÉ LUIS ANTÚNEZ GOICOCHEA')) }},
    presidenteCargo: {{ json_encode(old('presidenteCargo', $informe->presidente_cargo ?? 'Presidente Municipal Constitucional')) }},
    sindicatoNombre: {{ json_encode(old('sindicatoNombre', $informe->sindicato_nombre ?? 'Profa. Maricela Cruz Cedillo')) }},
    sindicatoCargo: {{ json_encode(old('sindicatoCargo', $informe->sindicato_cargo ?? 'Síndica Procuradora Municipal')) }},
    secretarioNombre: {{ json_encode(old('secretarioNombre', $informe->secretario_nombre ?? 'C. Profr. Mario Alberto Lagunas Salgado')) }},
    secretarioCargo: {{ json_encode(old('secretarioCargo', $informe->secretario_cargo ?? 'Secretario General del H. Ayuntamiento Municipal Constitucional')) }},
    regidores: {{ json_encode(old('regidores', $informe->regidores ?? $defaultRegidores)) }}
}" class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg mb-8 border border-gray-200 dark:border-gray-700">


    <div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-extrabold text-[#00713D] dark:text-green-400">INFORMACIÓN DE LA COMUNA</h2>
    <button type="button" 
            x-on:click="edit = !edit" 
            class="px-3 py-1 text-sm rounded-lg font-medium"
            x-bind:class="edit ? 'bg-red-500 dark:bg-red-600 text-white' : 'bg-green-500 dark:bg-green-600 text-white'">
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


    <!-- ✅ CAMBIO 4: Imagen de la Comuna con preview -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Foto de la Comuna (Funcionarios)</label>
        
        @if($isEdit && isset($informe->comuna_imagen_path) && $informe->comuna_imagen_path)
            <div class="mb-3 p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-700">
                <p class="text-sm text-green-700 dark:text-green-300 mb-2 font-semibold">
                    <i class="fas fa-info-circle mr-1"></i> Foto actual de la comuna:
                </p>
                <img src="{{ asset('storage/' . $informe->comuna_imagen_path) }}" 
                     alt="Comuna actual" 
                     class="max-w-xs rounded shadow">
                <p class="text-xs text-green-600 dark:text-green-400 mt-2 italic">
                    💡 Sube una nueva para reemplazarla
                </p>
            </div>
        @endif
        
        <div class="flex items-center justify-center w-full" id="upload-box-comuna">
            <label for="comuna-imagen" class="upload-box w-full">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">{{ $isEdit ? 'CAMBIAR' : 'CARGAR' }}</span> Foto Comuna</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">JPG, PNG (MAX. 5MB)</p>
                </div>
                <input id="comuna-imagen" name="comuna_imagen" type="file" class="hidden" {{ $isEdit ? '' : 'required' }}/>
            </label>
        </div>
        <div id="comuna-preview" class="preview-container"></div>
    </div>
    
    <div class="mt-6 flex justify-end">
        <button type="button" @click="nextTab()" class="px-4 py-2 rounded text-white !bg-[#00713D] dark:!bg-green-600 hover:bg-[#05924a] dark:hover:bg-green-700 transition">
            Siguiente →
        </button>
    </div>
    <!-- Mensaje de ayuda para redirección manual -->
<p class="mt-3 text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
    <svg class="w-5 h-5 flex-shrink-0 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span>
        <strong>Nota:</strong> Si después de procesar no es redirigido automáticamente, 
        <a href="{{ route('informes-generados') }}" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-300 font-semibold">
            haga clic aquí para ver sus informes actualizados.
        </a>
    </span>
</p>
</section>


<!-- INFORMACIÓN MUNICIPIO -->
<section x-show="current==='informacion'" x-cloak class="space-y-6">
    <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Información del Municipio</h2>

    <!-- ✅ CAMBIO 1: Agregar value al input de municipio_nombre -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Nombre del Municipio</label>
        <input 
            type="text" 
            name="municipio_nombre" 
            autocomplete="off"
            value="{{ old('municipio_nombre', $informe->municipio_nombre ?? '') }}"
            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 !bg-white dark:!bg-gray-700 !text-gray-900 dark:!text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-green-500" 
            placeholder="Nombre oficial del municipio" 
            required
        >
    </div>

    <!-- ✅ CAMBIO 2: Agregar data-content al textarea para Quill -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Descripción del Municipio</label>
        <div id="municipio-descripcion-editor" class="border rounded-md min-h-[150px]"></div>
        <textarea 
            name="municipio_descripcion" 
            id="municipio-descripcion-content" 
            class="hidden" 
            data-content="{{ old('municipio_descripcion', $informe->municipio_descripcion ?? '') }}" 
            required>{{ old('municipio_descripcion', $informe->municipio_descripcion ?? '') }}</textarea>
    </div>

    <!-- ✅ CAMBIO 3: Agregar preview y hacer opcional la imagen -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Imagen del Municipio</label>
        
        @if($isEdit && isset($informe->municipio_imagen_path) && $informe->municipio_imagen_path)
            <div class="mb-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-700">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-2 font-semibold">
                    <i class="fas fa-info-circle mr-1"></i> Imagen actual del municipio:
                </p>
                <img src="{{ asset('storage/' . $informe->municipio_imagen_path) }}" 
                     alt="Municipio actual" 
                     class="max-w-xs rounded shadow border border-gray-300 dark:border-gray-600">
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 italic">
                    💡 Sube una nueva imagen para reemplazarla
                </p>
            </div>
        @endif
        
        <div class="flex items-center justify-center w-full" id="upload-box-informacion">
            <label for="imagen-comuna-informacion" class="upload-box w-full">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold">{{ $isEdit ? 'CAMBIAR ARCHIVO' : 'CARGAR ARCHIVO' }}</span> SUBIR IMAGEN
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                </div>
                <input id="imagen-comuna-informacion" name="municipio_imagen" type="file" class="hidden" {{ $isEdit ? '' : 'required' }} />
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

    <!-- ✅ CAMBIO 1: Agregar data-content al textarea de introducción -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Introducción</label>
        <div id="introduccion-editor" class="border rounded-md bg-white dark:bg-gray-700 min-h-[150px]"></div>
        <textarea 
            name="introduccion" 
            id="introduccion-content" 
            class="hidden" 
            data-content="{{ old('introduccion', $informe->introduccion ?? '') }}" 
            required>{{ old('introduccion', $informe->introduccion ?? '') }}</textarea>
    </div>

    <!-- ✅ CAMBIO 2: Agregar preview y hacer opcional la imagen -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Imagen para Introducción</label>
        
        @if($isEdit && isset($informe->introduccion_imagen_path) && $informe->introduccion_imagen_path)
            <div class="mb-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-700">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-2 font-semibold">
                    <i class="fas fa-info-circle mr-1"></i> Imagen actual de introducción:
                </p>
                <img src="{{ asset('storage/' . $informe->introduccion_imagen_path) }}" 
                     alt="Introducción actual" 
                     class="max-w-xs rounded shadow border border-gray-300 dark:border-gray-600">
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 italic">
                    💡 Sube una nueva imagen para reemplazarla
                </p>
            </div>
        @endif
        
        <div class="flex items-center justify-center w-full" id="upload-box-introduccion">
            <label for="imagen-introduccion" class="upload-box w-full">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold">{{ $isEdit ? 'CAMBIAR ARCHIVO' : 'CARGAR ARCHIVO' }}</span> SUBIR IMAGEN
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                </div>
                <input id="imagen-introduccion" name="introduccion_imagen" type="file" class="hidden" {{ $isEdit ? '' : 'required' }} />
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

    <!-- ✅ CAMBIO 1: Agregar data-content al textarea de gobierno -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Contenido de la introducción del gobierno</label>
        <div id="gobierno-editor" class="border rounded-md bg-white dark:bg-gray-700 min-h-[150px]"></div>
        <textarea 
            name="gobierno_introduccion" 
            id="gobierno-content" 
            class="hidden" 
            data-content="{{ old('gobierno_introduccion', $informe->gobierno_introduccion ?? '') }}" 
            required>{{ old('gobierno_introduccion', $informe->gobierno_introduccion ?? '') }}</textarea>
    </div>

    <!-- ✅ CAMBIO 2: Agregar preview y hacer opcional la imagen -->
    <div>
        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Imagen del Gobierno</label>
        
        @if($isEdit && isset($informe->gobierno_imagen_path) && $informe->gobierno_imagen_path)
            <div class="mb-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-700">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-2 font-semibold">
                    <i class="fas fa-info-circle mr-1"></i> Imagen actual del gobierno:
                </p>
                <img src="{{ asset('storage/' . $informe->gobierno_imagen_path) }}" 
                     alt="Gobierno actual" 
                     class="max-w-xs rounded shadow border border-gray-300 dark:border-gray-600">
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 italic">
                    💡 Sube una nueva imagen para reemplazarla
                </p>
            </div>
        @endif
        
        <div class="flex items-center justify-center w-full" id="upload-box-gobierno">
            <label for="imagen-gobierno" class="upload-box w-full">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021 4 4 0 0 0 5 5a4 4 0 0 0 0 8h2.167M10 15V6L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold">{{ $isEdit ? 'CAMBIAR ARCHIVO' : 'CARGAR ARCHIVO' }}</span> SUBIR IMAGEN
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
                </div>
                <input id="imagen-gobierno" name="gobierno_imagen" type="file" class="hidden" {{ $isEdit ? '' : 'required' }} />
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
<section x-data="filtroSoloPeriodo(
    {{ json_encode($informe->actividades_fecha_inicio ?? null) }},
    {{ json_encode($informe->actividades_fecha_fin ?? null) }},
    {{ json_encode($informe->dependencias_seleccionadas ?? []) }}
)" x-init="start()" x-cloak x-show="current==='actividades'" class="space-y-6">
  <h2 class="text-2xl font-bold text-[#00713D] dark:text-green-400">Filtro de Actividades</h2>

  <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
    <p class="text-sm text-blue-800 dark:text-blue-300">
      <strong>Nota:</strong> Elige el periodo (anual, semestral o mensual) y dependencias; el rango se calcula automáticamente.
    </p>
  </div>

  <!-- Periodo (sin modo) -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Año -->
    <div class="relative max-w-xs">
      <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Año</label>
      <div class="relative">
        <div class="pointer-events-none absolute top-1/2 left-0 -translate-y-[calc(50%-2px)] flex items-center pl-3">
          <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
          </svg>
        </div>
        <select x-model.number="anio" x-on:change="recalcPeriodo(); actualizarConteo();"
                class="peer w-full appearance-none !bg-none rounded-lg border border-gray-300 pl-12 pr-9 h-12 text-base leading-[1.15rem] text-gray-900 shadow-sm outline-none
                       focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/40 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
          <template x-for="y in anios" :key="'y-'+y"><option :value="y" x-text="y"></option></template>
        </select>
        <div class="pointer-events-none absolute top-1/2 right-0 -translate-y-[calc(50%-2px)] flex items-center pr-3">
          <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"/>
          </svg>
        </div>
      </div>
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Año base del informe.</p>
    </div>

    <!-- Tipo -->
    <div>
      <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Tipo de periodo</label>
      <select x-model="tipo" x-on:change="onTipoChange"
              class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none
                     focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/40 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
        <option value="anio">Anual</option>
        <option value="semestre">Semestral</option>
        <option value="mes">Mensual</option>
      </select>
    </div>

    <!-- Semestre -->
    <div x-show="tipo==='semestre'">
      <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Semestre</label>
      <select x-model="semestre" x-on:change="recalcPeriodo(); actualizarConteo();"
              class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none
                     focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/40 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
        <option value="S1">Enero – Junio</option>
        <option value="S2">Julio – Diciembre</option>
      </select>
    </div>

    <!-- Mes exacto -->
    <div x-show="tipo==='mes'">
      <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Mes</label>
      <input type="month" x-model="mes" x-on:change="recalcPeriodo(); actualizarConteo();"
             class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm outline-none
                    focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/40 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"/>
    </div>
  </div>

  <!-- Dependencias como chips -->
  <div class="space-y-3">
    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Dependencias a Incluir</label>

    <div x-show="seleccionadas.length" class="flex flex-wrap gap-2">
      <template x-for="v in seleccionadas" :key="'chip-'+v">
        <span class="inline-flex items-center gap-1 rounded-full border border-blue-300 bg-blue-600 text-white px-3 py-1 text-xs shadow-sm ring-2 ring-blue-300 dark:ring-blue-500">
          <span x-text="labelDe(v)"></span>
          <button type="button" x-on:click="remove(v)"
                  class="ml-1 inline-flex h-5 w-5 items-center justify-center rounded-full hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-white/60"
                  aria-label="Quitar">
            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 8.586 5.757 4.343 4.343 5.757 8.586 10l-4.243 4.243 1.414 1.414L10 11.414l4.243 4.243 1.414-1.414L11.414 10l4.243-4.243-1.414-1.414L10 8.586z" clip-rule="evenodd"/></svg>
          </button>
        </span>
      </template>
    </div>

    <div class="flex flex-wrap gap-2">
      <template x-for="a in areas" :key="a.value">
        <button type="button" x-on:click="toggle(a.value)"
          class="px-3 py-1.5 rounded-full text-sm border transition focus:outline-none"
          x-bind:class="isSel(a.value)
            ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-400'
            : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600'">
          <span x-text="a.label"></span>
        </button>
      </template>
    </div>

    <template x-for="v in seleccionadas" :key="'hidden-'+v">
      <input type="hidden" name="dependencias[]" x-bind:value="v">
    </template>
  </div>

  <!-- Estado: conteo previo -->
  <div class="mt-2">
    <template x-if="loading">
      <div class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
        <svg class="h-4 w-4 animate-spin text-emerald-600" viewBox="0 0 24 24" aria-hidden="true">
            ircle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-e-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        Consultando actividades…
      </div>
    </template>

    <template x-if="!loading && hasResponse && count === 0">
      <div class="mt-2 rounded-md border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700 dark:border-rose-900/40 dark:bg-rose-900/20 dark:text-rose-300">
        No hay actividades para el rango y dependencias seleccionadas.
      </div>
    </template>

    <template x-if="!loading && hasResponse && count > 0">
      <div class="mt-2 rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700 dark:border-emerald-900/40 dark:bg-emerald-900/20 dark:text-emerald-300">
        Se encontraron <span class="font-semibold" x-text="count"></span> actividades.
      </div>
    </template>
  </div>

  <!-- Rango final para backend -->
  <input type="hidden" name="periodo_inicio" x-bind:value="inicio">
  <input type="hidden" name="periodo_fin" x-bind:value="fin">
  <input type="hidden" name="periodo_tipo" x-bind:value="tipo">

  <div class="flex justify-between mt-4">
    <button type="button" x-on:click="prevTab()" 
            class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
        ← Anterior
    </button>
    
    <button type="submit" 
            class="px-4 py-2 rounded text-white !bg-[#00713D] dark:!bg-green-600 hover:bg-[#05924a] dark:hover:bg-green-700 transition">
        {{ $isEdit ? 'Actualizar Informe' : 'Generar Informe' }}
    </button>
</div>

<!-- Mensaje de ayuda para redirección manual -->
<p class="mt-3 text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
    <svg class="w-5 h-5 flex-shrink-0 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span>
        <strong>Nota:</strong> Si después de procesar no es redirigido automáticamente, 
        <a href="{{ route('informes-generados') }}" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-300 font-semibold">
            haga clic aquí para ver sus informes
        </a>
    </span>
</p>

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

// ✅ CAMBIO 1: Cargar contenido existente en los editores Quill
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
                
                // ✅ CARGA EL CONTENIDO EXISTENTE SI ESTÁ EDITANDO
                const hiddenField = document.getElementById(cfg.hidden);
                if (hiddenField && hiddenField.dataset.content) {
                    quill.root.innerHTML = hiddenField.dataset.content;
                }
                
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
    Alpine.data('tabsForm', () => ({
        current: 'inicio',
        tabs: ['inicio', 'introduccion', 'informacion', 'gobierno', 'actividades'],
        showError: false,
        errorMessages: [], // ✅ Array que guarda los nombres de campos faltantes
        isEdit: {{ $isEdit ? 'true' : 'false' }},
        
        showToast(msgs) {
            this.errorMessages = msgs; // ✅ Asigna el array de campos faltantes
            this.showError = true;     // ✅ Muestra la alerta
            setTimeout(() => this.showError = false, 5000); // ✅ Oculta después de 5s
        },
        
validateTab() {
    // Si estamos editando, NO validar
    if (this.isEdit) {
        return true;
    }
    
    // Validación en modo creación
    const missing = [];
    
    // ============ TAB INICIO ============
    if (this.current === 'inicio') {
        if (!document.querySelector('#portada-principal-preview')?.children.length) {
            missing.push('Imagen de Portada Principal');
        }
        
        if (!document.querySelector('#plantilla-preview')?.children.length) {
            missing.push('Plantilla del Gobierno');
        }
        
        if (!document.querySelector('#comuna-preview')?.children.length) {
            missing.push('Imagen de Comuna');
        }
    }
    
    // ============ TAB INTRODUCCIÓN ============
    if (this.current === 'introduccion') {
        if (!window.quillEditors?.['introduccion-editor'] || 
            window.quillEditors['introduccion-editor'].getText().trim().length === 0) {
            missing.push('Contenido de Introducción');
        }
        
        if (!document.querySelector('#introduccion-preview')?.children.length) {
            missing.push('Imagen de Introducción');
        }
    }
    
    // ============ TAB INFORMACIÓN ============
    if (this.current === 'informacion') {
        if (!document.querySelector('input[name="municipio_nombre"]')?.value.trim()) {
            missing.push('Nombre del Municipio');
        }
        
        if (!window.quillEditors?.['municipio-descripcion-editor'] || 
            window.quillEditors['municipio-descripcion-editor'].getText().trim().length === 0) {
            missing.push('Descripción del Municipio');
        }
        
        if (!document.querySelector('#informacion-preview')?.children.length) {
            missing.push('Imagen del Municipio');
        }
    }
    
    // ============ TAB GOBIERNO ============
    if (this.current === 'gobierno') {
        if (!window.quillEditors?.['gobierno-editor'] || 
            window.quillEditors['gobierno-editor'].getText().trim().length === 0) {
            missing.push('Contenido de Gobierno');
        }
        
        if (!document.querySelector('#gobierno-preview')?.children.length) {
            missing.push('Imagen de Gobierno');
        }
    }
    
    // ============ TAB ACTIVIDADES ============
    if (this.current === 'actividades') {
        const dependenciasHidden = document.querySelectorAll('input[name="dependencias[]"]');
        if (dependenciasHidden.length === 0) {
            missing.push('Al menos una dependencia');
        }
    }
    
    // Si hay campos faltantes, mostrar alerta y bloquear
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
setupPreview('imagen-comuna-informacion', 'informacion-preview', 'upload-box-informacion');
setupPreview('imagen-introduccion', 'introduccion-preview', 'upload-box-introduccion');
setupPreview('imagen-gobierno', 'gobierno-preview', 'upload-box-gobierno');
setupPreview('plantilla-imagen', 'plantilla-preview', 'upload-box-plantilla');
setupPreview('portada-principal', 'portada-principal-preview', 'upload-box-portada-principal');
setupPreview('comuna-imagen', 'comuna-preview', 'upload-box-comuna');

function filtroSoloPeriodo(inicioEdit = null, finEdit = null, dependenciasEdit = []) {
  const añoActual = new Date().getFullYear();
  
  return {
    tipo: 'anio',
    anio: inicioEdit ? new Date(inicioEdit).getFullYear() : añoActual,
    anios: [],
    semestre: 'S1',
    mes: inicioEdit ? inicioEdit.slice(0, 7) : new Date().toISOString().slice(0,7),
    areas: [
        { value: 'Agua potable', label: 'Agua potable' },
        { value: 'Bienestar Social y Desarrollo Rural', label: 'Bienestar Social y Desarrollo Rural' },
        { value: 'Catastro', label: 'Catastro' },
        { value: 'Contraloria Interna', label: 'Contraloria Interna' },
        { value: 'Deportes', label: 'Deportes' },
        { value: 'DIF', label: 'DIF' },
        { value: 'Informática', label: 'Informática' },
        { value: 'Limpia', label: 'Limpia' },
        { value: 'Obras Publicas', label: 'Obras Publicas' },
        { value: 'Oficialia Mayor', label: 'Oficialia Mayor' },
        { value: 'Presidencia', label: 'Presidencia' },
        { value: 'Recursos Humanos', label: 'Recursos Humanos' },
        { value: 'Registro Civil', label: 'Registro Civil' },
        { value: 'Regidores', label: 'Regidores' },
        { value: 'Reglamentos', label: 'Reglamentos' },
        { value: 'Secretaria General', label: 'Secretaria General' },
        { value: 'Seguridad Publica', label: 'Seguridad Publica' },
        { value: 'Sindicatura', label: 'Sindicatura' },
        { value: 'Tesoreria', label: 'Tesoreria' },
        { value: 'Transito', label: 'Transito' },
    ],
    seleccionadas: Array.isArray(dependenciasEdit) ? [...dependenciasEdit] : [],
    loading: false, 
    hasResponse: false, 
    count: null,
    inicio: inicioEdit || '', 
    fin: finEdit || '',

    start() {
      this.anios = []; 
      for (let y = añoActual; y >= 2000; y--) {
        this.anios.push(y);
      }
      
      if (inicioEdit && finEdit) {
        this.inicio = inicioEdit;
        this.fin = finEdit;
        
        if (Array.isArray(dependenciasEdit) && dependenciasEdit.length > 0) {
          this.seleccionadas = [...dependenciasEdit];
        }
        
        // ✅ SOLUCIÓN: Leer el año del DOM después del render
        setTimeout(() => {
          const yearSelect = document.querySelector('select[x-model\\.number="anio"]');
          if (yearSelect && yearSelect.value) {
            this.anio = parseInt(yearSelect.value);
          }
          
          this.recalcPeriodo();
          this.actualizarConteo();
        }, 700);
      } else {
        this.recalcPeriodo();
        setTimeout(() => {
          this.actualizarConteo();
        }, 100);
      }
    },
    
    onTipoChange() {
      if (this.tipo === 'semestre' && !['S1','S2'].includes(this.semestre)) {
        this.semestre = 'S1';
      }
      if (this.tipo === 'mes' && !/^\d{4}-\d{2}$/.test(this.mes)) {
        this.mes = `${this.anio}-01`;
      }
      this.recalcPeriodo(); 
      this.actualizarConteo();
    },

    isSel(v) { 
      return this.seleccionadas.includes(v); 
    },
    
    labelDe(v) { 
      const area = this.areas.find(a => a.value === v);
      return area ? area.label : v; 
    },
    
    toggle(v) { 
      const i = this.seleccionadas.indexOf(v); 
      if (i === -1) {
        this.seleccionadas.push(v);
      } else {
        this.seleccionadas.splice(i, 1);
      }
      this.actualizarConteo(); 
    },
    
    remove(v) { 
      const i = this.seleccionadas.indexOf(v); 
      if (i !== -1) {
        this.seleccionadas.splice(i, 1);
      }
      this.actualizarConteo(); 
    },

    recalcPeriodo() {
      if (this.tipo === 'anio') {
        this.inicio = `${this.anio}-01-01`; 
        this.fin = `${this.anio}-12-31`;
      } else if (this.tipo === 'semestre') {
        if (this.semestre === 'S1') { 
          this.inicio = `${this.anio}-01-01`; 
          this.fin = `${this.anio}-06-30`; 
        } else { 
          this.inicio = `${this.anio}-07-01`; 
          this.fin = `${this.anio}-12-31`; 
        }
      } else if (this.tipo === 'mes') {
        const [yy, mm] = this.mes.split('-').map(n => parseInt(n,10));
        const last = new Date(yy, mm, 0).getDate();
        this.inicio = `${yy}-${String(mm).padStart(2,'0')}-01`;
        this.fin = `${yy}-${String(mm).padStart(2,'0')}-${last}`;
      }
    },

    async actualizarConteo() {
      if (!this.inicio || !this.fin) { 
        this.count = null; 
        this.hasResponse = false; 
        return; 
      }
      
      this.loading = true; 
      this.hasResponse = false;
      
      const params = new URLSearchParams({ 
        start: this.inicio, 
        end: this.fin, 
        areas: this.seleccionadas.join(',') 
      });
      
      try {
        const res = await fetch(`/api/actividades/contar?${params.toString()}`, { 
          headers: { 'Accept': 'application/json' } 
        });
        
        if (!res.ok) { 
          this.count = null; 
          return; 
        }
        
        const json = await res.json();
        this.count = json?.count ?? 0; 
        this.hasResponse = true;
      } catch (error) {
        console.error('Error al contar actividades:', error);
        this.count = null;
      } finally { 
        this.loading = false; 
      }
    }
  }
}


</script>
@endsection
