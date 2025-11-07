@extends('layouts.master-public')

@section('title', 'Inicio')

@section('css')
<style>
    .carousel-item {
        display: none;
        animation: fadeIn 1s ease-in-out;
    }
    .carousel-item.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endsection

@section('content')

@php
// Obtener datos del presidente y fotos del carrusel
$presidente = \App\Models\Presidente::first();
$fotosCarrusel = \App\Models\CarruselFoto::orderBy('orden')->get();
@endphp

{{-- Título Principal --}}
<div class="text-center py-8 bg-gradient-to-r from-green-700 to-green-600 text-white shadow-lg">
    <h1 class="text-4xl md:text-5xl font-bold mb-2">Bienvenidos</h1>
    <p class="text-lg md:text-xl px-4">
        Portal de Transparencia del H. Ayuntamiento Constitucional del Municipio de Tlapehuala, Guerrero.
    </p>
</div>

{{-- Carrusel de Imágenes --}}
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
        
        {{-- Botón Gestionar (Solo para usuarios autenticados) --}}
        @auth
        <button onclick="abrirModalGestionar()" 
                class="absolute top-4 right-4 z-20 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-lg transition flex items-center gap-2">
            <i class="ri-settings-3-line"></i>
            <span>Gestionar Fotos</span>
        </button>
        @endauth

        {{-- Carrusel --}}
        @if($fotosCarrusel->count() > 0)
        <div id="carousel" class="relative h-[400px] md:h-[600px]">
            @foreach($fotosCarrusel as $index => $foto)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }} absolute inset-0">
                <img src="{{ asset('storage/carrusel/' . $foto->imagen) }}" 
                     alt="Slide {{ $index + 1 }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                @if($foto->titulo)
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <h3 class="text-3xl font-bold mb-2">{{ $foto->titulo }}</h3>
                    @if($foto->descripcion)
                    <p class="text-lg">{{ $foto->descripcion }}</p>
                    @endif
                </div>
                @endif
            </div>
            @endforeach

            {{-- Controles del carrusel --}}
            <button onclick="cambiarSlide(-1)" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition z-10">
                <i class="ri-arrow-left-s-line text-2xl"></i>
            </button>
            <button onclick="cambiarSlide(1)" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition z-10">
                <i class="ri-arrow-right-s-line text-2xl"></i>
            </button>

            {{-- Indicadores --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                @foreach($fotosCarrusel as $index => $foto)
                <button onclick="irASlide({{ $index }})" 
                        class="indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition {{ $index === 0 ? 'bg-white' : '' }}"></button>
                @endforeach
            </div>
        </div>
        @else
        {{-- Estado vacío --}}
        <div class="h-[400px] md:h-[600px] flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
            <div class="text-center p-8">
                <i class="ri-image-line text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">No hay imágenes en el carrusel</h3>
                @auth
                <button onclick="abrirModalGestionar()" 
                        class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-lg transition">
                    <i class="ri-add-line mr-2"></i>Agregar Fotos
                </button>
                @endauth
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Sección del Presidente --}}
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8 relative">
        
        @auth
        <button onclick="abrirModalEditar()" 
                class="absolute top-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-lg transition flex items-center gap-2">
            <i class="ri-edit-line"></i>
            <span>Editar</span>
        </button>
        @endauth

        <div class="flex flex-col items-center text-center">
            <img src="{{ asset('storage/presidentes/' . $presidente->foto) }}" 
                 alt="Presidente"
                 class="w-48 h-48 md:w-64 md:h-64 object-cover rounded-full border-4 border-green-600 shadow-xl mb-6 transition-all duration-300 hover:scale-105">
            
            <p class="text-sm text-gray-500 mb-2" id="fechaHoy"></p>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $presidente->nombre }}</h2>
            <p class="text-lg text-green-600 font-semibold mb-4">{{ $presidente->cargo }}</p>
            <p class="text-gray-600 leading-relaxed max-w-2xl">{{ $presidente->biografia }}</p>
        </div>
    </div>
</div>

{{-- MODAL GESTIONAR CARRUSEL --}}
@auth
<div id="modalGestionar" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl my-8 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 rounded-t-2xl z-10">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Gestionar Carrusel</h3>
                <button onclick="cerrarModalGestionar()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="ri-close-line text-3xl"></i>
                </button>
            </div>
        </div>
        
        <div class="p-6">
            {{-- Subir nueva foto --}}
            <div class="mb-8 p-6 bg-green-50 dark:bg-green-900/20 rounded-xl border-2 border-dashed border-green-300 dark:border-green-700">
                <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">📤 Subir Nueva Foto</h4>
                <form action="{{ route('carrusel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Título (opcional):</label>
                            <input type="text" name="titulo" 
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Orden:</label>
                            <input type="number" name="orden" value="0" min="0"
                                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Descripción (opcional):</label>
                        <textarea name="descripcion" rows="2" 
                                  class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Imagen:</label>
                        <input type="file" name="imagen" accept="image/*" required
                               class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-600 dark:file:text-gray-200">
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                        <i class="ri-upload-line mr-2"></i>Subir Foto
                    </button>
                </form>
            </div>

            {{-- Lista de fotos actuales --}}
            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">🖼️ Fotos Actuales</h4>
            <div class="grid md:grid-cols-2 gap-4">
                @forelse($fotosCarrusel as $foto)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl overflow-hidden shadow-md">
                    <img src="{{ asset('storage/carrusel/' . $foto->imagen) }}" 
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $foto->titulo ?: 'Sin título' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Orden: {{ $foto->orden }}</p>
                            </div>
                        </div>
                        <form action="{{ route('carrusel.destroy', $foto->id) }}" method="POST" 
                              onsubmit="return confirm('¿Eliminar esta foto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg transition text-sm">
                                <i class="ri-delete-bin-line mr-1"></i>Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-8 text-gray-500 dark:text-gray-400">
                    No hay fotos en el carrusel
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endauth

{{-- MODAL EDITAR PRESIDENTE --}}
@auth
<div id="modalEditar" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl my-8 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 rounded-t-2xl">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Editar Presidente Municipal</h3>
        </div>
        
        <form action="{{ route('presidente.actualizar') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Nombre completo:</label>
                <input type="text" name="nombre" value="{{ $presidente->nombre }}" 
                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-600" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Cargo:</label>
                <input type="text" name="cargo" value="{{ $presidente->cargo }}" 
                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-600" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Biografía:</label>
                <textarea name="biografia" rows="5" 
                          class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-600" required>{{ $presidente->biografia }}</textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Foto actual:</label>
                <img src="{{ asset('storage/presidentes/' . $presidente->foto) }}" 
                     class="w-32 h-32 object-cover rounded-lg mb-2 border-2 border-gray-200 dark:border-gray-600">
                
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2 mt-4">Cambiar foto (opcional):</label>
                <input type="file" name="foto" accept="image/*" 
                       class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-600 dark:file:text-gray-200">
            </div>
            
            <div class="flex gap-4 pt-4">
                <button type="submit" 
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition shadow-md">
                    💾 Guardar Cambios
                </button>
                <button type="button" onclick="cerrarModalEditar()" 
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 rounded-lg transition shadow-md">
                    ❌ Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

@endsection

@section('script')
<script>
// Carrusel automático
let slideActual = 0;
let intervalo;

function mostrarSlide(n) {
    const slides = document.querySelectorAll('.carousel-item');
    const indicators = document.querySelectorAll('.indicator');
    
    if (n >= slides.length) slideActual = 0;
    if (n < 0) slideActual = slides.length - 1;
    
    slides.forEach((slide, index) => {
        slide.classList.remove('active');
        if (indicators[index]) indicators[index].classList.remove('bg-white');
        if (indicators[index]) indicators[index].classList.add('bg-white/50');
    });
    
    if (slides[slideActual]) {
        slides[slideActual].classList.add('active');
        if (indicators[slideActual]) {
            indicators[slideActual].classList.add('bg-white');
            indicators[slideActual].classList.remove('bg-white/50');
        }
    }
}

function cambiarSlide(n) {
    clearInterval(intervalo);
    slideActual += n;
    mostrarSlide(slideActual);
    iniciarAutomatico();
}

function irASlide(n) {
    clearInterval(intervalo);
    slideActual = n;
    mostrarSlide(slideActual);
    iniciarAutomatico();
}

function iniciarAutomatico() {
    intervalo = setInterval(() => {
        slideActual++;
        mostrarSlide(slideActual);
    }, 5000); // Cambia cada 5 segundos
}

// Iniciar carrusel
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.carousel-item');
    if (slides.length > 1) {
        iniciarAutomatico();
    }
});

// Modales
function abrirModalGestionar() {
    document.getElementById('modalGestionar').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function cerrarModalGestionar() {
    document.getElementById('modalGestionar').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
function abrirModalEditar() {
    document.getElementById('modalEditar').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function cerrarModalEditar() {
    document.getElementById('modalEditar').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fecha
const fecha = new Date();
const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
document.getElementById('fechaHoy').textContent = fecha.toLocaleDateString('es-MX', opciones);
</script>
@endsection