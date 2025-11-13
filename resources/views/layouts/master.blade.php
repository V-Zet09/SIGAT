<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- ✅ AGREGAR ESTA LÍNEA --}}
    
    <title>@yield('title') - SIGAT</title>
    
    <!-- ⚡ CRÍTICO: Aplica dark mode ANTES de cargar CSS -->
    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    <link rel="shortcut icon" href="{{ URL::asset('images/LOGO_VENTANA_SF.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    
    @vite([
        'resources/scss/app.scss',
        'resources/scss/icons.scss',
        'resources/js/app.js'
    ])
    
    @yield('css')
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                darkMode: localStorage.getItem('theme') === 'dark',
                
                toggle() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.darkMode);
                }
            });
        });
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    
    <div class="flex min-h-screen" x-data>
        
        {{-- Sidebar --}}
        @include('layouts.sidebar')
        
        {{-- Main content --}}
        <div class="flex-1 ml-64 transition-colors duration-300">
            @hasSection('navbar')
                @yield('navbar')
            @endif
            
            <main class="p-6 min-h-screen bg-gray-50 dark:bg-gray-900">
                @yield('content')
            </main>
            
            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </div>
    
    @include('layouts.vendor-scripts')
    @yield('scripts')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
</body>
</html>