@extends('layouts.master-public')

@section('title', 'Inicio')

@section('content')

@php
// Obtener datos del presidente desde la base de datos
$presidente = \App\Models\Presidente::first();

$dependencias = [
    [
        'nombre' => 'Obras Públicas',
        'logo' => asset('images/obraspublicas.png'),
        'descripcion' => 'Encargada de infraestructura y mantenimiento urbano.',
        'ruta' => route('dependencias.obras_publicas')
    ],
    [
        'nombre' => 'Educación',
        'logo' => asset('images/educacion.png'),
        'descripcion' => 'Promueve programas educativos y capacitación.',
        'ruta' => route('dependencias.educacion')
    ],
    [
        'nombre' => 'Salud',
        'logo' => asset('images/salud.jpg'),
        'descripcion' => 'Servicios médicos y prevención comunitaria.',
        'ruta' => route('dependencias.salud')
    ],
    [
        'nombre' => 'Tesorería',
        'logo' => asset('images/tesoreria.png'),
        'descripcion' => 'Gestión de finanzas municipales.',
        'ruta' => route('dependencias.tesoreria')
    ],
    [
        'nombre' => 'Cultura',
        'logo' => asset('images/cultura.png'),
        'descripcion' => 'Fomento de actividades culturales y artísticas.',
        'ruta' => route('dependencias.cultura')
    ],
];
@endphp

<!-- Contenedor principal -->
<div class="w-full shadow-inner">
    <div class="w-full max-w-7xl mx-auto py-12 px-4 sm:px-6 md:px-8 lg:px-0">
        <div class="w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">
                Registro Municipal de Trámites
            </h2>

            <select 
              id="buscador-municipal"
              class="w-full p-3 rounded-lg border border-gray-300 shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600
                    text-gray-600">
              <option value="" selected>¿Qué está buscando?</option>
              <option value="{{ route('ayuntamiento') }}">Ayuntamiento</option>
              <option value="{{ route('gobierno') }}">Gobierno</option>
              <option value="{{ route('sala-de-prensa') }}">Sala de prensa</option>
              <option value="{{ route('login') }}">Iniciar sesión</option>
            </select>
        </div>
    </div>
</div>


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

<!-- Dependencias Institucionales -->
<section class="max-w-screen-xl mx-auto px-4 py-8">
  <h3 class="text-2xl font-bold text-[#00713D] mb-6 text-center">
    Dependencias Institucionales
  </h3>

  <div class="relative">
    <!-- Carrusel -->
    <div id="carousel" class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-4 no-scrollbar">
      @foreach ($dependencias as $dep)
      <article class="snap-start flex-shrink-0 w-72 min-w-[18rem] p-4 rounded-xl border border-gray-200/60 bg-white shadow-md transition transform hover:scale-105">
        <div class="flex flex-col items-center gap-3">
          <img src="{{ asset($dep['logo']) }}" alt="Logo {{ $dep['nombre'] }}" 
               class="w-16 h-16 min-w-[64px] min-h-[64px] object-contain" 
               loading="lazy" decoding="async">
          <h4 class="text-lg font-semibold text-gray-800">{{ $dep['nombre'] }}</h4>
          <p class="text-sm text-gray-500 text-center">{{ $dep['descripcion'] }}</p>
          <a href="{{ $dep['ruta'] }}" class="mt-3 inline-flex px-4 py-2 rounded-full font-semibold text-white bg-[#00713D] hover:bg-[#005c30] transition">
            Ver dependencia
          </a>
        </div>
      </article>
      @endforeach
    </div>

    <!-- Botones de navegación -->
    <button onclick="scrollCarousel(-1)"
            class="flex absolute top-1/2 -left-3 -translate-y-1/2 bg-[#00713D]/80 hover:bg-[#00713D] text-white p-3 rounded-full shadow-lg transition-opacity opacity-80 hover:opacity-100 z-10">
      &#8592;
    </button>

    <button onclick="scrollCarousel(1)"
            class="flex absolute top-1/2 -right-3 -translate-y-1/2 bg-[#00713D]/80 hover:bg-[#00713D] text-white p-3 rounded-full shadow-lg transition-opacity opacity-80 hover:opacity-100 z-10">
      &#8594;
    </button>
  </div>
</section>

<script>
    // Poner fecha de hoy
    const fecha = new Date();
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('fechaHoy').textContent = fecha.toLocaleDateString('es-MX', opciones);

    // Función scroll carrusel
    function scrollCarousel(direction) {
        const carousel = document.getElementById('carousel');
        const cardWidth = carousel.querySelector('article').offsetWidth + 16;
        carousel.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
    }

    // Movimiento automático
    window.addEventListener('load', () => {
        const carousel = document.getElementById('carousel');
        let direction = 1;
        setInterval(() => {
            if (carousel.scrollLeft + carousel.clientWidth >= carousel.scrollWidth) direction = -1;
            if (carousel.scrollLeft <= 0) direction = 1;
            scrollCarousel(direction);
        }, 3000);
    });

    // Redirigir buscador
    document.getElementById('buscador-municipal').addEventListener('change', function() {
      const url = this.value;
      if (url) {
          window.location.href = url;
      }
    });
</script>

<style>
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

@endsection