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

<!-- Navbar con SIGAT centrado -->
<nav class="bg-gradient-to-r from-green-600 via-green-500 to-green-600 shadow-lg border-b-4 border-green-700">
 <div class="flex items-center justify-between max-w-screen-xl mx-auto px-6 py-4 md:px-8 lg:px-10">

    <!-- Logos izquierda -->
    <div class="flex items-center space-x-4">
      <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl hover:bg-white/30 transition-all duration-300">
        <img src="{{ asset('images/logo-trabajando-juntos.png') }}" class="h-10" alt="Logo Trabajando Juntos" />
      </div>
      <div class="bg-white/20 backdrop-blur-sm p-2 rounded-xl hover:bg-white/30 transition-all duration-300">
        <img src="{{ asset('images/LOGO-TLAPE.png') }}" class="h-10" alt="Logo Tlapehuala" />
      </div>
    </div>

    <!-- SIGAT grande centrado -->
    <div class="absolute left-1/2 transform -translate-x-1/2 text-center">
      <h1 class="text-4xl md:text-5xl font-black text-white tracking-wider drop-shadow-lg">SIGAT</h1>
      <p class="text-xs md:text-sm text-green-100 font-medium mt-1">Sistema Integral de Gestión</p>
    </div>

    <!-- Horario de atención (derecha) -->
    <div class="hidden lg:block text-right">
      <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
        <p class="text-xs text-white font-bold flex items-center justify-end">
          <i class="ri-time-line mr-1 text-base"></i> Horario de Atención
        </p>
        <p class="text-xs text-green-100 mt-1">Lun-Vie: 9:00 AM - 3:00 PM</p>
      </div>
    </div>

  </div>
</nav>

  <!-- Contenido principal -->
  <main class="flex-1 pt-0 pb-16 px-4 sm:px-6 md:px-10 lg:px-20">
    @yield('content')
  </main>

  <!-- Footer horizontal compacto -->
  <footer class="mt-auto bg-gray-900 text-gray-300 py-4">
    <div class="max-w-screen-xl mx-auto px-4">
      
      <!-- Layout horizontal en 3 columnas -->
      <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        
        <!-- Columna izquierda: Info -->
        <div class="text-center md:text-left">
          <p class="text-sm font-bold text-white">SIGAT - Tlapehuala</p>
          <p class="text-xs text-gray-400">© 2025 Todos los derechos reservados</p>
        </div>

        <!-- Columna centro: Redes sociales -->
        <div class="flex space-x-3">
          <a href="https://github.com/V-Zet09" target="_blank" 
             class="bg-gray-800 p-2.5 rounded-lg hover:bg-gray-700 transition-all duration-300 hover:scale-110">
            <i class="ri-github-fill text-xl text-white"></i>
          </a>
          <a href="https://www.instagram.com/tlapehualagob/" target="_blank" 
             class="bg-gradient-to-br from-pink-500 to-purple-600 p-2.5 rounded-lg hover:scale-110 transition-all duration-300">
            <i class="ri-instagram-fill text-xl text-white"></i>
          </a>
          <a href="https://www.facebook.com/tlapehualagob" target="_blank" 
             class="bg-blue-600 p-2.5 rounded-lg hover:bg-blue-700 transition-all duration-300 hover:scale-110">
            <i class="ri-facebook-fill text-xl text-white"></i>
          </a>
        </div>

        <!-- Columna derecha: Créditos -->
        <div class="text-center md:text-right">
          <p class="text-xs text-gray-500">
            <span class="text-green-400 font-semibold">Maico, Mariana, Jorge, José</span>
          </p>
          <p class="text-xs text-gray-600">Ingeniería Informática</p>
        </div>

      </div>

    </div>
  </footer>

  <!-- Flowbite JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>

  @yield('script')
</body>
</html>
