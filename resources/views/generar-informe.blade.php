@extends('layouts.master')

@section('title', 'Generar Informe')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/flowbite@1.8.1/dist/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<style>
  [x-cloak] { display: none !important; }
  .preview-container { display:flex; gap:.5rem; flex-wrap:wrap; margin-top:.5rem; }
  .preview-image-container { position:relative; width:120px; height:80px; border:1px solid #e5e7eb; border-radius:.375rem; overflow:hidden; display:flex; align-items:center; justify-content:center; }
  .preview-image { width:100%; height:100%; object-fit:cover; }
  .remove-image-btn { position:absolute; top:4px; right:4px; background:rgba(0,0,0,.6); color:white; border-radius:9999px; width:22px; height:22px; display:flex; align-items:center; justify-content:center; border:none; cursor:pointer; }
  .upload-box { cursor:pointer; border:1px dashed #cbd5e1; padding:1rem; border-radius:.5rem; display:flex; align-items:center; justify-content:center; text-align:center; }
  .upload-box.dragover { border-color:#22c55e; background:#f0fff4; }
  .is-invalid { border-color: #ef4444 !important; }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded-2xl shadow" x-data="{ current: 'inicio' }">

    <!-- Toast -->
    <div x-data="{show:false}" x-show="show" x-transition class="fixed top-6 right-6 bg-green-600 text-white px-4 py-2 rounded" x-cloak>
        Información guardada correctamente
    </div>

    <!-- Tabs -->
    <nav class="mb-6 border-b border-gray-200">
        <ul class="flex gap-6 text-sm text-gray-600">
            <li>
                <button @click="current='inicio'" :class="current==='inicio' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Inicio</button>
            </li>
            <li>
                <button @click="current='informacion'" :class="current==='informacion' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Información Municipio</button>
            </li>
            <li>
                <button @click="current='introduccion'" :class="current==='introduccion' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Introducción</button>
            </li>
            <li>
                <button @click="current='gobierno'" :class="current==='gobierno' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Introducción Gobierno</button>
            </li>
            <li>
                <button @click="current='actividades'" :class="current==='actividades' ? 'text-[#00713D] border-b-2 border-[#00713D] pb-2' : 'pb-2'" class="focus:outline-none">Actividades</button>
            </li>
        </ul>
    </nav>

    <form id="informeForm" method="POST" action="{{ route('informes.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- INICIO -->
        <section x-show="current==='inicio'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Portada</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Título del Informe</label>
                    <input type="text" name="titulo" class="w-full rounded-md border-gray-300 px-3 py-2" placeholder="Ingrese el título" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Período</label>
                    <input type="text" id="periodo" name="periodo" class="w-full rounded-md border-gray-300 px-3 py-2" placeholder="Selecciona el período" required>
                </div>
            </div>

            <!-- Información de la comuna -->
            <div class="mt-6 bg-gray-50 p-4 rounded-md border">
                <h3 class="text-lg font-semibold">INFORMACIÓN DE LA COMUNA</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-3 bg-white rounded shadow-sm">
                        <h4 class="font-semibold">Presidencia</h4>
                        <p class="text-sm"><strong>C. JOSÉ LUIS ANTÚNEZ GOICOCHEA</strong><br>Presidente Municipal Constitucional</p>
                    </div>
                    <div class="p-3 bg-white rounded shadow-sm">
                        <h4 class="font-semibold">Sindicato</h4>
                        <p class="text-sm"><strong>Profa. Maricela Cruz Cedillo</strong><br>Síndica Procuradora Municipal</p>
                    </div>
                    <div class="p-3 bg-white rounded shadow-sm">
                        <h4 class="font-semibold">Secretaría</h4>
                        <p class="text-sm"><strong>C. Profr. Mario Alberto Lagunas Salgado</strong><br>Secretario General del H. Ayuntamiento Municipal Constitucional</p>
                    </div>
                </div>

                <h4 class="mt-4 font-semibold">Regidores</h4>
                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            <li><strong>C. Zenón Huerta Arellano</strong> Desarrollo Urbano, Medio Ambiente y Obras Públicas</li>
                            <li><strong>C. Ma. del Carmen Barrera Galarza</strong> Educación, Cultura, Recreación, Espectáculos y Juventud</li>
                            <li><strong>C. Arturo León Juan</strong> Salud y Asistencia Social</li>
                        </ul>
                    </div>
                    <div>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            <li><strong>C. Ma. Isabel Quintana Gómez</strong> Equidad y Género, Derecho de las Niñas y Adolescentes</li>
                            <li><strong>C. Jesús Javier Cruz</strong> Desarrollo Rural, Participación Social de Migrantes</li>
                            <li><strong>C. Edith Aguirre Flores</strong> Comercio, Abasto Popular, Atención y Fomento al Empleo</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div id="upload-box" class="upload-box" role="button">
                    <div>
                        <div class="text-xl">📁</div>
                        <div class="text-sm">Arrastra tu imagen aquí o <span class="font-semibold">selecciona desde tu dispositivo</span></div>
                    </div>
                    <input type="file" id="imagen-comuna-inicio" name="imagen_comuna" class="hidden" accept="image/*" required>
                </div>
                <div id="upload-preview" class="preview-container"></div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" @click="current='informacion'" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:!bg-[#05924a] transition">Siguiente →</button>
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
                <textarea name="municipio_descripcion" class="w-full rounded-md border-gray-300 px-3 py-2" rows="5" placeholder="Descripción detallada del municipio" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Imagen del Municipio</label>
                <div class="mt-2">
                    <div id="informacion-upload" class="upload-box">
                        <div>
                            <div class="text-xl">📁</div>
                            <div class="text-sm">Arrastra tu imagen aquí o <span class="font-semibold">selecciona desde tu dispositivo</span></div>
                        </div>
                        <input type="file" id="imagen-comuna-informacion" name="imagen_comuna_informacion" class="hidden" accept="image/*" required>
                    </div>
                    <div id="informacion-preview" class="preview-container"></div>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="button" @click="current='inicio'" class="px-4 py-2 rounded !bg-gray-200 hover:!bg-gray-300 transition">← Anterior</button>
                <button type="button" @click="current='introduccion'" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:!bg-[#05924a] transition">Siguiente →</button>
            </div>
        </section>

        <!-- INTRODUCCIÓN -->
        <section x-show="current==='introduccion'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Introducción</h2>
            <div>
                <label class="block text-sm font-medium mb-1">Contenido de la introducción (máximo 800 palabras)</label>
                <div class="border rounded-md bg-white">
                    <div class="p-2 flex gap-2 border-b">
                        <button type="button" data-command="bold" class="px-2 py-1 border rounded text-sm">B</button>
                        <button type="button" data-command="italic" class="px-2 py-1 border rounded text-sm">I</button>
                        <button type="button" data-command="underline" class="px-2 py-1 border rounded text-sm">U</button>
                        <select data-command="formatBlock" class="ml-2 border rounded p-1 text-sm">
                            <option value="" selected>Estilo</option>
                            <option value="h1">Título 1</option>
                            <option value="h2">Título 2</option>
                            <option value="h3">Título 3</option>
                            <option value="p">Párrafo</option>
                        </select>
                    </div>
                    <div id="introduccion-editor" class="editor-content p-4 min-h-[150px]" contenteditable="true" style="outline:none;"></div>
                </div>
                <textarea name="introduccion" id="introduccion-content" class="hidden" required></textarea>
                <div class="text-sm text-gray-600 mt-1" id="wordCount">0 / 800 palabras</div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Imagen para Introducción</label>
                <div id="introduccion-upload" class="upload-box">
                    <div>
                        <div class="text-xl">📁</div>
                        <div class="text-sm">Arrastra tu imagen aquí o <span class="font-semibold">selecciona desde tu dispositivo</span></div>
                    </div>
                    <input type="file" id="imagen-comuna-introduccion" name="imagen_comuna_introduccion" class="hidden" accept="image/*" required>
                </div>
                <div id="introduccion-preview" class="preview-container"></div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="button" @click="current='informacion'" class="px-4 py-2 rounded !bg-gray-200 hover:!bg-gray-300 transition">← Anterior</button>
                <button type="button" @click="current='gobierno'" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:!bg-[#05924a] transition">Siguiente →</button>
            </div>
        </section>

        <!-- GOBIERNO -->
        <section x-show="current==='gobierno'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Introducción del Gobierno</h2>
            <div>
                <label class="block text-sm font-medium mb-1">Contenido de la introducción del gobierno</label>
                <textarea name="gobierno_introduccion" class="w-full rounded-md border-gray-300 px-3 py-2" rows="8" placeholder="Describa la introducción al gobierno municipal" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Imagen del Gobierno</label>
                <div id="gobierno-upload" class="upload-box">
                    <div>
                        <div class="text-xl">📁</div>
                        <div class="text-sm">Arrastra tu imagen aquí o <span class="font-semibold">selecciona desde tu dispositivo</span></div>
                    </div>
                    <input type="file" id="imagen-comuna-gobierno" name="imagen_comuna_gobierno" class="hidden" accept="image/*" required>
                </div>
                <div id="gobierno-preview" class="preview-container"></div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="button" @click="current='introduccion'" class="px-4 py-2 rounded !bg-gray-200 hover:!bg-gray-300 transition">← Anterior</button>
                <button type="button" @click="current='actividades'" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:!bg-[#05924a] transition">Siguiente →</button>
            </div>
        </section>

        <!-- ACTIVIDADES -->
        <section x-show="current==='actividades'" x-cloak class="space-y-6">
            <h2 class="text-2xl font-bold text-[#00713D]">Actividades</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Seleccione el período:</label>
                    <select name="actividades_periodo" class="w-full rounded-md border-gray-300 px-3 py-2" required>
                        <option value="Enero - Marzo">Enero - Marzo</option>
                        <option value="Abril - Junio">Abril - Junio</option>
                        <option value="Julio - Septiembre">Julio - Septiembre</option>
                        <option value="Octubre - Diciembre">Octubre - Diciembre</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Áreas:</label>
                    <div class="flex flex-wrap gap-3">
                        <label class="inline-flex items-center"><input type="checkbox" name="areas[]" value="Cultura" class="mr-2">Cultura</label>
                        <label class="inline-flex items-center"><input type="checkbox" name="areas[]" value="Educación" class="mr-2">Educación</label>
                        <label class="inline-flex items-center"><input type="checkbox" name="areas[]" value="Salud" class="mr-2">Salud</label>
                        <label class="inline-flex items-center"><input type="checkbox" name="areas[]" value="Deportes" class="mr-2">Deportes</label>
                        <label class="inline-flex items-center"><input type="checkbox" name="areas[]" value="Seguridad" class="mr-2">Seguridad</label>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Descripción de las actividades</label>
                <textarea name="actividades_descripcion" class="w-full rounded-md border-gray-300 px-3 py-2" rows="8" placeholder="Describa las actividades realizadas" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Imágenes de Actividades (Máximo 5)</label>
                <div id="actividades-upload" class="upload-box">
                    <div>
                        <div class="text-xl">📁</div>
                        <div class="text-sm">Arrastra tus imágenes aquí o <span class="font-semibold">selecciona desde tu dispositivo</span></div>
                    </div>
                    <input type="file" id="imagen-comuna-actividades" name="imagenes_actividades[]" class="hidden" accept="image/*" multiple required>
                </div>
                <div id="actividades-preview" class="preview-container"></div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="button" @click="current='gobierno'" class="px-4 py-2 rounded !bg-gray-200 hover:!bg-gray-300 transition">← Anterior</button>
                <button type="submit" class="px-4 py-2 rounded text-white !bg-[#00713D] hover:!bg-[#05924a] transition">Guardar Informe</button>
            </div>
        </section>

    </form>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('informeTabs', () => ({
        current: 'inicio',
        tabs: ['inicio','informacion','introduccion','gobierno','actividades'],
        nextTab(tab){ this.current = tab },
        prevTab(tab){ this.current = tab }
    }))
})

// Flatpickr
flatpickr("#periodo", {
    plugins: [
        new monthSelectPlugin({
            shorthand: true,
            dateFormat: "F Y",
            altFormat: "F Y"
        })
    ]
});

// Editor Introducción
const editor = document.getElementById('introduccion-editor');
const textarea = document.getElementById('introduccion-content');
const wordCount = document.getElementById('wordCount');

editor.addEventListener('input', function(){
    textarea.value = editor.innerHTML;
    let text = editor.innerText.trim();
    let words = text.split(/\s+/).filter(Boolean);
    wordCount.innerText = words.length + ' / 800 palabras';
});
document.querySelectorAll('#introduccion-editor + div [data-command]').forEach(btn=>{
    btn.addEventListener('click', ()=> editor.execCommand(btn.dataset.command, false, null))
});
document.querySelectorAll('#introduccion-editor + div select[data-command]').forEach(sel=>{
    sel.addEventListener('change', ()=> editor.execCommand(sel.dataset.command, false, sel.value))
});

// Upload previews
function setupUpload(idInput, idPreview){
    const input = document.getElementById(idInput);
    const preview = document.getElementById(idPreview);
    const box = document.getElementById(idInput.replace('imagen-comuna','upload'));
    box.addEventListener('click', ()=> input.click());
    box.addEventListener('dragover', e=> { e.preventDefault(); box.classList.add('dragover'); });
    box.addEventListener('dragleave', e=> { e.preventDefault(); box.classList.remove('dragover'); });
    box.addEventListener('drop', e=> { e.preventDefault(); box.classList.remove('dragover'); input.files = e.dataTransfer.files; showPreview(); });

    input.addEventListener('change', showPreview);

    function showPreview(){
        preview.innerHTML = '';
        Array.from(input.files).forEach(file=>{
            const reader = new FileReader();
            reader.onload = e=>{
                const div = document.createElement('div');
                div.classList.add('preview-image-container');
                div.innerHTML = `<img src="${e.target.result}" class="preview-image"><button type="button" class="remove-image-btn">&times;</button>`;
                div.querySelector('button').addEventListener('click', ()=>{
                    input.value = '';
                    div.remove();
                });
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        })
    }
}

setupUpload('imagen-comuna-inicio','upload-preview');
setupUpload('imagen-comuna-informacion','informacion-preview');
setupUpload('imagen-comuna-introduccion','introduccion-preview');
setupUpload('imagen-comuna-gobierno','gobierno-preview');
setupUpload('imagen-comuna-actividades','actividades-preview');
</script>
@endsection
