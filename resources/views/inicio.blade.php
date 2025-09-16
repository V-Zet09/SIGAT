@extends('layouts.master-public')

@section('title', 'Inicio')

@section('content')

@php
$dependencias = [
    [
        'nombre' => 'Obras Públicas',
        'logo' => 'images/obraspublicas.png',
        'descripcion' => 'Encargada de infraestructura y mantenimiento urbano.'
    ],
    [
        'nombre' => 'Educación',
        'logo' => 'images/educacion.png',
        'descripcion' => 'Promueve programas educativos y capacitación.'
    ],
    [
        'nombre' => 'Salud',
        'logo' => 'images/salud.jpg',
        'descripcion' => 'Servicios médicos y prevención comunitaria.'
    ],
    [
        'nombre' => 'Tesorería',
        'logo' => 'images/tesoreria.png',
        'descripcion' => 'Gestión de finanzas municipales.'
    ],
    [
        'nombre' => 'Cultura',
        'logo' => 'images/cultura.png',
        'descripcion' => 'Fomento de actividades culturales y artísticas.'
    ],
];
@endphp

<!-- Contenedor principal sin fondo verde -->
<div class="w-full shadow-inner">
    <div class="w-full max-w-7xl mx-auto py-12 px-4 sm:px-6 md:px-8 lg:px-0">
        <div class="w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">
                Registro Municipal de Trámites
            </h2>

            <select 
                class="w-full p-3 rounded-lg border border-gray-300 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600
                       text-gray-600">
                <option selected>¿Qué está buscando?</option>
                <option>Centro de Atención al Emprendedor - SEDETI</option>
                <option>Fortalecimiento a la micro y pequeña empresa</option>
                <option>Aviso de Apertura Inmediata</option>
                <option>Bolsa de Trabajo</option>
            </select>
        </div>
    </div>
</div>

{{-- Noticia principal --}}
@if($noticiaPrincipal)
    <x-noticia-card 
        :imagen="$noticiaPrincipal->imagen"
        :fecha="$noticiaPrincipal->fecha"
        :titulo="$noticiaPrincipal->titulo"
        :url="route('noticias.show', $noticiaPrincipal->id)"
    />
@endif


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

<section class="py-12">
  <div class="max-w-screen-xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center text-[#00713D] mb-10">
      Últimos Comunicados
    </h2>

    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

      {{-- Noticias secundarias --}}
@foreach($noticiasSecundarias as $noticia)
    <x-noticia-card 
        :imagen="$noticia->imagen"
        :fecha="$noticia->fecha"
        :titulo="$noticia->titulo"
        :url="route('noticias.show', $noticia->id)"
    />
@endforeach

    </div>

    <div class="mt-12 flex justify-center">
      <a href="{{ route('noticias.todos') }}"
         class="px-8 py-3 bg-[#00713D] hover:bg-[#005c30] text-white font-bold rounded-full shadow-md transition">
        VER TODOS LOS COMUNICADOS
      </a>
    </div>
  </div>
</section>

<!-- Institucionales - Carrusel -->
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
          <a href="#" class="mt-3 inline-flex px-4 py-2 rounded-full font-semibold text-white bg-[#00713D] hover:bg-[#005c30] transition">
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

<!-- Trámites -->
<section class="max-w-screen-xl mx-auto px-4 py-12">
  <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">
    Trámites en Línea
  </h2>

  <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <!-- CURP -->
    <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
      <img src="images/curp.png" alt="Trámite CURP" class="w-16 h-16 mb-4 object-contain">
      <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Trámite CURP</h3>
      <a href="https://www.gob.mx/curp" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#A7D7C5] hover:bg-[#8EC5B3] text-white font-semibold transition">
        Iniciar trámite
      </a>
    </div>

    <!-- Acta de nacimiento -->
    <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
      <img src="images/actadenacimiento.png" alt="Acta de nacimiento" class="w-16 h-16 mb-4 object-contain">
      <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Acta de Nacimiento</h3>
      <a href="https://www.miregistrocivil.gob.mx/" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#A7D7C5] hover:bg-[#8EC5B3] text-white font-semibold transition">
        Iniciar trámite
      </a>
    </div>

    <!-- Pago de Agua -->
    <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
      <img src="images/pagodeagua.jpg" alt="Pago de Agua" class="w-16 h-16 mb-4 object-contain">
      <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Pago de Agua</h3>
      <a href="/tramites/agua" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#A7D7C5] hover:bg-[#8EC5B3] text-white font-semibold transition">
        Iniciar trámite
      </a>
    </div>

    <!-- Pago de Luz -->
    <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
      <img src="images/pagodeluz.png" alt="Pago de Luz" class="w-16 h-16 mb-4 object-contain">
      <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Pago de Luz</h3>
      <a href="https://app.cfe.mx/Aplicaciones/CCFE/MiEspacio/login.aspx" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#A7D7C5] hover:bg-[#8EC5B3] text-white font-semibold transition">
        Iniciar trámite
      </a>
    </div>

    <!-- Tránsito -->
    <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
      <img src="images/transito.jpg" alt="Tránsito" class="w-16 h-16 mb-4 object-contain">
      <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Trámite de Tránsito</h3>
      <a href="/tramites/transito" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#A7D7C5] hover:bg-[#8EC5B3] text-white font-semibold transition">
        Iniciar trámite
      </a>
    </div>

    <!-- Reglas y Reglamentos -->
    <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
      <img src="images/reglamentos.png" alt="Reglamentos" class="w-16 h-16 mb-4 object-contain">
      <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Reglamentos</h3>
      <a href="/tramites/reglamentos" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#A7D7C5] hover:bg-[#8EC5B3] text-white font-semibold transition">
        Iniciar trámite
      </a>
    </div>

    <!-- Otros trámites -->
    <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
      <img src="images/otros.png" alt="Otros trámites" class="w-16 h-16 mb-4 object-contain">
      <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Otros trámites</h3>
      <a href="/tramites/otros" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#A7D7C5] hover:bg-[#8EC5B3] text-white font-semibold transition">
        Iniciar trámite
      </a>
    </div>
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
</script>

<style>
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

@endsection
