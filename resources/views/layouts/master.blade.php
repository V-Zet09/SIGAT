<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-layout="vertical"
      data-topbar="light"
      data-sidebar="light"
      data-sidebar-style="default"
      data-sidebar-size="lg"
      data-sidebar-image="none"
      data-preloader="disable"
      data-theme="default"
      data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | SIGAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="SIGAT Dashboard" name="description" />
    <meta content="SIGAT" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ URL::asset('images/LOGO_VENTANA_SF.png') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite([
        'resources/scss/bootstrap.scss',    
        'resources/scss/icons.scss',
        'resources/scss/app.scss',
        'resources/scss/custom.scss',
        'resources/js/app.js'
    ])

    @yield('css')
</head>

<body class="bg-gray-50 text-gray-900 transition-colors duration-200">
    <div id="layout-wrapper">
        
        @hasSection('sidebar')
            @yield('sidebar')
        @else
            @include('layouts.sidebar')
        @endif

        <div class="main-content lg:ml-64 bg-gray-50 transition-colors duration-200">
            
            @hasSection('navbar')
                @yield('navbar')
            @endif

            <div class="page-content" style="padding-top: 1rem;">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('layouts.footer')

        </div>
    </div>

    @include('layouts.vendor-scripts')
    @yield('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
</body>
</html>
