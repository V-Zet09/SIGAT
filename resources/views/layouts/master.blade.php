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

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/LOGO_VENTANA_SF.png') }}">

    <!-- Librerías externas -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          integrity="sha512-..."
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />

    <!-- RemixIcon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

    {{-- Vite: Estilos y JS principales --}}
    @vite([
        'resources/scss/bootstrap.scss',    
        'resources/scss/icons.scss',
        'resources/scss/app.scss',
        'resources/scss/custom.scss',
        'resources/js/app.js'
    ])

    {{-- CSS adicional por vista --}}
    @yield('css')
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        
        {{-- Sidebar opcional --}}
        @hasSection('sidebar')
            @yield('sidebar')
        @else
            @include('layouts.sidebar')
        @endif

        <!-- ============================================================== -->
        <!-- Start main content -->
        <!-- ============================================================== -->
        <div class="main-content" style="margin-left: 250px;">
            
            {{-- Navbar opcional --}}
            @hasSection('navbar')
                @yield('navbar')
            @endif

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    {{-- Vendor scripts --}}
    @include('layouts.vendor-scripts')

    {{-- Scripts por vista --}}
    @yield('scripts')

    <!-- Flowbite -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
</body>
</html>
