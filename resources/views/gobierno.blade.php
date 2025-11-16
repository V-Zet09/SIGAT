@extends('layouts.master-public')

@section('title', 'Gobierno Municipal')

@section('css')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .card-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .presidente-card:hover .presidente-badge {
        animation: float 2s ease-in-out infinite;
    }
    
    .gradient-border {
        position: relative;
        background: linear-gradient(white, white) padding-box,
                    linear-gradient(135deg, #10b981, #3b82f6, #8b5cf6) border-box;
        border: 3px solid transparent;
    }
    
    .dark .gradient-border {
        background: linear-gradient(#1f2937, #1f2937) padding-box,
                    linear-gradient(135deg, #10b981, #3b82f6, #8b5cf6) border-box;
    }

    .edit-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .editable-field:hover .edit-overlay {
        display: flex;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideUp 0.3s;
    }

    .dark .modal-content {
        background: #1f2937;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .image-preview {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin-top: 1rem;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        {{-- Botón de Edición (solo visible para usuarios autenticados) --}}
        @auth
        <div class="fixed bottom-8 right-8 z-50">
            <button onclick="toggleEditMode()" id="editModeBtn" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 transition-all duration-300 hover:scale-110">
                <i class="ri-edit-line text-xl"></i>
                <span class="font-semibold">Modo Edición</span>
            </button>
        </div>
        @endauth

        {{-- Header Principal --}}
        <div class="text-center mb-12 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg mb-4">
                <i class="ri-government-line text-4xl text-white"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 mb-3">
                Gobierno Municipal de Tlapehuala
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 font-medium">Periodo {{ $gobierno->periodo ?? '2024 - 2027' }}</p>
            <div class="mt-4 flex items-center justify-center gap-2">
                <span class="h-1 w-12 bg-gradient-to-r from-green-500 to-transparent rounded-full"></span>
                <i class="ri-sparkling-line text-2xl text-green-500"></i>
                <span class="h-1 w-12 bg-gradient-to-l from-green-500 to-transparent rounded-full"></span>
            </div>
        </div>

        {{-- Presidente Municipal --}}
        <div class="mb-16 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 inline-flex items-center gap-3">
                    <i class="ri-user-star-line text-green-600"></i>
                    Presidente Municipal
                </h2>
            </div>
            
            <div class="presidente-card card-hover gradient-border rounded-3xl overflow-hidden bg-white dark:bg-gray-800 shadow-2xl">
                <div class="grid md:grid-cols-2 gap-8 p-8">
                    {{-- Imagen --}}
                    <div class="relative">
                        <div class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-400 to-blue-500 rounded-full opacity-20 blur-2xl"></div>
                        <div class="relative aspect-square rounded-2xl overflow-hidden shadow-2xl border-4 border-white dark:border-gray-700 editable-field" data-field="presidente_imagen">
                            <img src="{{ $gobierno->presidente_imagen ?? asset('resources/images/presi.jpg') }}" 
                                 alt="Presidente Municipal" 
                                 class="w-full h-full object-cover"
                                 id="presidenteImagen">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            @auth
                            <div class="edit-overlay">
                                <div class="text-white text-center">
                                    <i class="ri-camera-line text-4xl mb-2"></i>
                                    <p class="font-semibold">Cambiar Foto</p>
                                </div>
                            </div>
                            @endauth
                        </div>
                        {{-- Badge flotante --}}
                        <div class="presidente-badge absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-full shadow-xl">
                            <i class="ri-shield-star-line mr-2"></i>
                            <span class="font-bold">Presidente</span>
                        </div>
                    </div>
                    
                    {{-- Información --}}
                    <div class="flex flex-col justify-center space-y-6">
                        <div>
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400 mb-2 uppercase tracking-wider">
                                Presidente Municipal Constitucional
                            </p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4 editable-field relative" data-field="presidente_nombre">
                                <span id="presidenteNombre">{{ $gobierno->presidente_nombre ?? 'C. José Luis Antúnez Goicochea' }}</span>
                                @auth
                                <button class="edit-btn absolute -right-2 -top-2 opacity-0 transition-opacity">
                                    <i class="ri-edit-line text-green-600 text-xl"></i>
                                </button>
                                @endauth
                            </h3>
                        </div>
                        
                        <div class="space-y-4">
                            {{-- Contacto --}}
                            <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl editable-field relative" data-field="presidente_telefono">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="ri-phone-line text-2xl text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Teléfono de Contacto</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100" id="presidenteTelefono">{{ $gobierno->presidente_telefono ?? '7328980098' }}</p>
                                </div>
                                @auth
                                <button class="edit-btn absolute top-2 right-2 opacity-0 transition-opacity">
                                    <i class="ri-edit-line text-blue-600"></i>
                                </button>
                                @endauth
                            </div>
                            
                            {{-- Facebook --}}
                            <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-600 rounded-xl editable-field relative" data-field="presidente_facebook">
                                <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="ri-facebook-circle-line text-2xl text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Facebook Oficial</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100" id="presidenteFacebook">{{ $gobierno->presidente_facebook ?? 'José Luis Antúnez Goicochea' }}</p>
                                </div>
                                @auth
                                <button class="edit-btn absolute top-2 right-2 opacity-0 transition-opacity">
                                    <i class="ri-edit-line text-purple-600"></i>
                                </button>
                                @endauth
                            </div>
                            
                            {{-- Dirección --}}
                            <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 rounded-xl editable-field relative" data-field="presidente_direccion">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="ri-map-pin-line text-2xl text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dirección</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100" id="presidenteDireccion">{{ $gobierno->presidente_direccion ?? 'Palacio Municipal, Tlapehuala' }}</p>
                                </div>
                                @auth
                                <button class="edit-btn absolute top-2 right-2 opacity-0 transition-opacity">
                                    <i class="ri-edit-line text-green-600"></i>
                                </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cabildo Municipal --}}
        <div class="animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 inline-flex items-center gap-3 mb-2">
                    <i class="ri-team-line text-blue-600"></i>
                    Cabildo Municipal
                </h2>
                <p class="text-gray-600 dark:text-gray-400">Honorable Ayuntamiento Constitucional</p>
            </div>

            {{-- Foto Grupal del Cabildo --}}
            <div class="mb-8 card-hover editable-field relative" data-field="cabildo_imagen">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ $gobierno->cabildo_imagen ?? asset('images/cabildo-municipal.jpg') }}" 
                         alt="Cabildo Municipal" 
                         class="w-full h-auto object-cover"
                         id="cabildoImagen">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">Honorable Cabildo Municipal 2024-2027</h3>
                        <p class="text-gray-200">Trabajando juntos por Tlapehuala</p>
                    </div>
                    @auth
                    <div class="edit-overlay">
                        <div class="text-white text-center">
                            <i class="ri-camera-line text-4xl mb-2"></i>
                            <p class="font-semibold">Cambiar Foto del Cabildo</p>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            {{-- Síndica --}}
            <div class="mb-8">
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-gray-200 dark:border-gray-700 editable-field relative" data-field="sindica">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0 w-24 h-24 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ substr($gobierno->sindica_nombre ?? 'MC', 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 text-xs font-bold rounded-full mb-2">
                                SÍNDICA PROCURADORA
                            </span>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100" id="sindicaNombre">
                                {{ $gobierno->sindica_nombre ?? 'Profa. Maricela Cruz Cedillo' }}
                            </h3>
                        </div>
                        <div class="hidden md:block">
                            <i class="ri-scales-line text-5xl text-pink-200 dark:text-pink-800"></i>
                        </div>
                    </div>
                    @auth
                    <button class="edit-btn absolute top-4 right-4 opacity-0 transition-opacity">
                        <i class="ri-edit-line text-pink-600 text-xl"></i>
                    </button>
                    @endauth
                </div>
            </div>

            {{-- Regidores Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($gobierno->regidores ?? [] as $index => $regidor)
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border-l-4 border-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-500 editable-field relative" data-field="regidor_{{ $index }}">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gradient-to-br from-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-500 to-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-600 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            {{ substr($regidor['nombre'], 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 bg-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-100 dark:bg-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-900 text-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-700 dark:text-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-300 text-xs font-semibold rounded mb-2">
                                {{ $regidor['cargo'] ?? 'REGIDOR' }}
                            </span>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $regidor['nombre'] }}
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                <i class="{{ $regidor['icono'] ?? 'ri-user-line' }} text-{{ ['blue', 'purple', 'green', 'pink', 'yellow', 'indigo'][$index % 6] }}-500 mt-1"></i>
                                <span>{{ $regidor['comision'] }}</span>
                            </p>
                        </div>
                    </div>
                    @auth
                    <button class="edit-btn absolute top-4 right-4 opacity-0 transition-opacity">
                        <i class="ri-edit-line text-gray-600 text-xl"></i>
                    </button>
                    @endauth
                </div>
                @empty
                {{-- Regidores por defecto (tu código actual) --}}
                @endforelse
            </div>

            {{-- Secretario General --}}
            <div class="card-hover bg-gradient-to-r from-gray-800 to-gray-900 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 shadow-2xl text-white editable-field relative" data-field="secretario">
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0 w-24 h-24 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ substr($gobierno->secretario_nombre ?? 'ML', 0, 2) }}
                    </div>
                    <div class="flex-1">
                        <span class="inline-block px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full mb-2">
                            SECRETARIO GENERAL
                        </span>
                        <h3 class="text-2xl font-bold mb-1" id="secretarioNombre">
                            {{ $gobierno->secretario_nombre ?? 'C. Profr. Mario Alberto Lagunas Salgado' }}
                        </h3>
                        <p class="text-gray-300">Secretario General del H. Ayuntamiento Municipal Constitucional</p>
                    </div>
                    <div class="hidden md:block">
                        <i class="ri-file-text-line text-5xl text-white/20"></i>
                    </div>
                </div>
                @auth
                <button class="edit-btn absolute top-4 right-4 opacity-0 transition-opacity">
                    <i class="ri-edit-line text-amber-400 text-xl"></i>
                </button>
                @endauth
            </div>
        </div>

    </div>
</div>

{{-- Modal de Edición --}}
@auth
<div id="editModal" class="modal">
    <div class="modal-content dark:text-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Información</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>
        <form id="editForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="field" id="fieldName">
            <div id="formContent"></div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-semibold transition-all">
                    <i class="ri-save-line mr-2"></i>Guardar
                </button>
                <button type="button" onclick="closeModal()" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

@endsection

@section('scripts')
@auth
<script>
    let editMode = false;

    function toggleEditMode() {
        editMode = !editMode;
        const editableFields = document.querySelectorAll('.editable-field');
        const editBtns = document.querySelectorAll('.edit-btn');
        const btn = document.getElementById('editModeBtn');
        
        if (editMode) {
            btn.classList.add('bg-gradient-to-r', 'from-red-600', 'to-pink-600');
            btn.classList.remove('from-blue-600', 'to-indigo-600');
            btn.innerHTML = '<i class="ri-close-line text-xl"></i><span class="font-semibold">Cancelar Edición</span>';
            editBtns.forEach(btn => btn.classList.remove('opacity-0'));
            editableFields.forEach(field => field.style.cursor = 'pointer');
        } else {
            btn.classList.remove('from-red-600', 'to-pink-600');
            btn.classList.add('from-blue-600', 'to-indigo-600');
            btn.innerHTML = '<i class="ri-edit-line text-xl"></i><span class="font-semibold">Modo Edición</span>';
            editBtns.forEach(btn => btn.classList.add('opacity-0'));
            editableFields.forEach(field => field.style.cursor = 'default');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const editableFields = document.querySelectorAll('.editable-field');
        
        editableFields.forEach(field => {
            field.addEventListener('click', function(e) {
                if (!editMode) return;
                
                const fieldName = this.dataset.field;
                openEditModal(fieldName);
            });
        });
    });

    function openEditModal(fieldName) {
        const modal = document.getElementById('editModal');
        const formContent = document.getElementById('formContent');
        document.getElementById('fieldName').value = fieldName;
        
        let content = '';
        
        // Generar contenido del formulario según el campo
        if (fieldName === 'presidente_imagen' || fieldName === 'cabildo_imagen') {
            content = `
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Subir nueva imagen</label>
                    <input type="file" name="imagen" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700" required onchange="previewImage(event)">
                    <img id="imagePreview" class="image-preview hidden">
                </div>
            `;
        } else if (fieldName === 'presidente_nombre') {
            content = `
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nombre del Presidente</label>
                    <input type="text" name="valor" value="${document.getElementById('presidenteNombre').textContent}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700" required>
                </div>
            `;
        } else if (fieldName === 'presidente_telefono') {
            content = `
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Teléfono</label>
                    <input type="tel" name="valor" value="${document.getElementById('presidenteTelefono').textContent}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700" required>
                </div>
            `;
        } else if (fieldName === 'presidente_facebook') {
            content = `
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Facebook</label>
                    <input type="text" name="valor" value="${document.getElementById('presidenteFacebook').textContent}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700" required>
                </div>
            `;
        } else if (fieldName === 'presidente_direccion') {
            content = `
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Dirección</label>
                    <input type="text" name="valor" value="${document.getElementById('presidenteDireccion').textContent}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700" required>
                </div>
            `;
        } else if (fieldName === 'sindica') {
            content = `
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nombre de la Síndica</label>
                    <input type="text" name="valor" value="${document.getElementById('sindicaNombre').textContent.trim()}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700" required>
                </div>
            `;
        } else if (fieldName === 'secretario') {
            content = `
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nombre del Secretario General</label>
                    <input type="text" name="valor" value="${document.getElementById('secretarioNombre').textContent.trim()}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700" required>
                </div>
            `;
        }
        
        formContent.innerHTML = content;
        modal.classList.add('active');
    }

    function closeModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const fieldName = document.getElementById('fieldName').value;
        
        try {
            const response = await fetch('{{ route("gobierno.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Actualizar la vista con los nuevos datos
                updateView(fieldName, data.data);
                closeModal();
                
                // Mostrar mensaje de éxito
                showNotification('¡Cambios guardados exitosamente!', 'success');
            } else {
                showNotification('Error al guardar los cambios', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Error al procesar la solicitud', 'error');
        }
    });

    function updateView(fieldName, data) {
        if (fieldName === 'presidente_imagen') {
            document.getElementById('presidenteImagen').src = data.imagen_url;
        } else if (fieldName === 'cabildo_imagen') {
            document.getElementById('cabildoImagen').src = data.imagen_url;
        } else if (fieldName === 'presidente_nombre') {
            document.getElementById('presidenteNombre').textContent = data.valor;
        } else if (fieldName === 'presidente_telefono') {
            document.getElementById('presidenteTelefono').textContent = data.valor;
        } else if (fieldName === 'presidente_facebook') {
            document.getElementById('presidenteFacebook').textContent = data.valor;
        } else if (fieldName === 'presidente_direccion') {
            document.getElementById('presidenteDireccion').textContent = data.valor;
        } else if (fieldName === 'sindica') {
            document.getElementById('sindicaNombre').textContent = data.valor;
        } else if (fieldName === 'secretario') {
            document.getElementById('secretarioNombre').textContent = data.valor;
        }
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-2xl transform transition-all duration-300 ${
            type === 'success' 
                ? 'bg-gradient-to-r from-green-500 to-emerald-600' 
                : 'bg-gradient-to-r from-red-500 to-pink-600'
        } text-white font-semibold`;
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="ri-${type === 'success' ? 'check' : 'error-warning'}-line text-2xl"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endauth

@endsection