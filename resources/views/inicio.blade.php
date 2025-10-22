@extends('layouts.master-public')

@section('title', 'Inicio')

@section('content')

@php
// Obtener datos del presidente desde la base de datos
$presidente = \App\Models\Presidente::first();
@endphp

<div class="flex justify-center mt-8 relative">
    <img class="h-auto max-w-full lg:max-w-lg transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0" 
         src="{{ asset('storage/presidentes/' . $presidente->foto) }}" alt="Presidente" loading="lazy" decoding="async">
    
    <!-- BOTÓN EDITAR - Solo lo ven los logueados -->
    @auth
    <button onclick="abrirModalEditar()" 
            class="absolute top-4 right-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-lg transition">
        ✏️ Editar
    </button>
    @endauth
</div>

<div class="flex flex-col items-center mt-4 text-center relative">
    <p class="text-sm text-gray-500" id="fechaHoy"></p>
    <p class="text-lg font-semibold text-gray-800 mt-1">{{ $presidente->cargo }}: {{ $presidente->nombre }}</p>
    <p class="text-gray-600 mt-2 max-w-xl">
        {{ $presidente->biografia }}
    </p>
</div>


<!-- MODAL PARA EDITAR - Solo aparece si estás logueado -->
@auth
<div id="modalEditar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl my-8 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-lg">
            <h3 class="text-2xl font-bold text-gray-800">Editar Presidente Municipal</h3>
        </div>
        
        <form action="{{ route('presidente.actualizar') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nombre completo:</label>
                <input type="text" name="nombre" value="{{ $presidente->nombre }}" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:outline-none" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Cargo:</label>
                <input type="text" name="cargo" value="{{ $presidente->cargo }}" 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:outline-none" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Biografía:</label>
                <textarea name="biografia" rows="5" 
                          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:outline-none" required>{{ $presidente->biografia }}</textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Foto actual:</label>
                <img src="{{ asset('storage/presidentes/' . $presidente->foto) }}" class="w-32 h-32 object-cover rounded-lg mb-2 border border-gray-200">
                
                <label class="block text-gray-700 font-semibold mb-2 mt-4">Cambiar foto (opcional):</label>
                <input type="file" name="foto" accept="image/*" 
                       class="w-full p-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>
            
            <!-- Botones fijos al final -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 pt-4 flex gap-4">
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

<script>
function abrirModalEditar() {
    document.getElementById('modalEditar').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Bloquear scroll del body
}
function cerrarModalEditar() {
    document.getElementById('modalEditar').classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restaurar scroll
}
</script>
@endauth

<script>
    // Poner fecha de hoy
    const fecha = new Date();
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('fechaHoy').textContent = fecha.toLocaleDateString('es-MX', opciones);
</script>

@endsection