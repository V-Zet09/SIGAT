<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <title>@yield('title') | SIGAT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="SIGAT Dashboard" name="description" />
  <meta content="SIGAT" name="author" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ URL::asset('images/LOGO_VENTANA_SF.png') }}">

  <!-- RemixIcon -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

  <!-- Tailwind + SCSS -->
  @vite([
    'resources/scss/bootstrap.scss',
    'resources/scss/icons.scss',
    'resources/scss/app.scss',
    'resources/scss/custom.scss',
    'resources/js/app.js'
  ])

  @yield('css')
</head>
<body class="flex flex-col min-h-screen bg-[#E5E7EB]">

<!-- Navbar -->
<nav class="bg-[#4CAF50] border-b border-gray-200 shadow-md">
 <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto px-4 py-2 md:px-6 lg:px-8">

    <!-- Logos -->
    <div class="flex items-center space-x-3">
      <img src="{{ asset('images/logo-trabajando-juntos.png') }}" class="h-8" alt="Logo Trabajando Juntos" />
      <img src="{{ asset('images/LOGO-TLAPE.png') }}" class="h-8" alt="Logo Tlapehuala" />
    </div>

    <!-- Botón hamburguesa móvil -->
    <button id="hamburger-button" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-white rounded-lg md:hidden hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300"
            aria-controls="mega-menu" aria-expanded="false">
      <span class="sr-only">Abrir menú</span>
      <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14" xmlns="http://www.w3.org/2000/svg">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
      </svg>
    </button>

    <!-- Menú principal -->
    <div id="mega-menu" class="hidden md:flex md:w-auto md:order-1 items-center justify-between w-full mt-4 md:mt-0">
      <ul class="flex flex-col md:flex-row md:space-x-6 list-none">
        <li>
          <a href="{{ route('inicio') }}" 
            class="block py-1.5 px-3 text-white hover:bg-green-600 md:hover:bg-transparent md:hover:text-gray-100 rounded transition-colors font-bold text-lg">
            Inicio
          </a>
        </li>

        <li>
          <a href="{{ route('gobierno') }}" 
            class="block py-1.5 px-3 text-white hover:bg-green-600 md:hover:bg-transparent md:hover:text-gray-100 rounded transition-colors font-bold text-lg">
            Gobierno
          </a>
        </li>

        <li>
          <a href="{{ route('ayuntamiento') }}" 
            class="block py-1.5 px-3 text-white hover:bg-green-600 md:hover:bg-transparent md:hover:text-gray-100 rounded transition-colors font-bold text-lg">
            Ayuntamiento
          </a>
        </li>

        <li>
          <a href="{{ route('sala-de-prensa') }}" 
            class="block py-1.5 px-3 text-white hover:bg-green-600 md:hover:bg-transparent md:hover:text-gray-100 rounded transition-colors font-bold text-lg">
            Sala de prensa
          </a>
        </li>

        <li>
          <a href="{{ route('login') }}" 
            class="block py-1.5 px-3 text-white hover:bg-green-600 md:hover:bg-transparent md:hover:text-gray-100 rounded transition-colors font-bold text-lg">
            Iniciar sesión
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <!-- Contenido principal -->
  <main class="flex-1 pt-0 pb-16 px-4 sm:px-6 md:px-10 lg:px-20">
    @yield('content')
  </main>

  <!-- Footer institucional -->
  <footer class="mt-auto border-t bg-white py-6">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center text-sm text-gray-500 px-4 md:px-0">
      <!-- Texto del footer -->
      <div>
        © 2025 Municipio de Tlapehuala™. Todos los derechos reservados.
      </div>

      <!-- Íconos sociales -->
      <div class="flex space-x-4">
        <a href="https://github.com/V-Zet09" target="_blank" class="text-gray-400 hover:text-gray-700">
          <i class="ri-github-fill text-3xl"></i>
        </a>
        <a href="https://www.instagram.com/tlapehualagob/" target="_blank" class="text-gray-400 hover:text-pink-500">
          <i class="ri-instagram-fill text-3xl"></i>
        </a>
        <a href="https://www.facebook.com/tlapehualagob" target="_blank" class="text-gray-400 hover:text-blue-600">
          <i class="ri-facebook-fill text-3xl"></i>
        </a>
      </div>
    </div>
  </footer>

  <!-- Flowbite JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>

  @yield('script')

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Toggle menú hamburguesa
    const hamburgerBtn = document.getElementById('hamburger-button');
    const megaMenu = document.getElementById('mega-menu');
    
    if (hamburgerBtn && megaMenu) {
      hamburgerBtn.addEventListener('click', function() {
        megaMenu.classList.toggle('hidden');
      });
    }

    // Toggle dropdown
    const dropdownBtn = document.getElementById('mega-menu-dropdown-button');
    const dropdownMenu = document.getElementById('mega-menu-dropdown');
    
    if (dropdownBtn && dropdownMenu) {
      dropdownBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
      });

      // Cerrar dropdown si clic fuera
      document.addEventListener('click', function(e) {
        if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
          dropdownMenu.classList.add('hidden');
        }
      });
    }
  });
  </script>
</body>
</html>