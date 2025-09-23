@extends('layouts.master-public')

@section('title', 'Inicio')

@section('content')

@php
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


<div class="flex justify-center mt-8">
    <img class="h-auto max-w-full lg:max-w-lg transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0" 
         src="images/carrusel1.jpeg" alt="Promoción" loading="lazy" decoding="async">
</div>

<div class="flex flex-col items-center mt-4 text-center">
    <p class="text-sm text-gray-500" id="fechaHoy"></p>
    <p class="text-lg font-semibold text-gray-800 mt-1">Presidente de Tlapehual: José Luis Antúnez Goichoce</p>
    <p class="text-gray-600 mt-2 max-w-xl">
        José Luis Antúnez Goichoce ha dedicado su vida al desarrollo de Tlapehual, fomentando proyectos
        comunitarios, educación y bienestar social. Con amplia experiencia en liderazgo local,
        busca impulsar la cultura y fortalecer la identidad de la comunidad.
    </p>
</div>

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
        const cardWidth = carousel.querySelector('article').offsetWidth + 16; // ancho + gap
        carousel.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
    }

    // Movimiento automático opcional
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
