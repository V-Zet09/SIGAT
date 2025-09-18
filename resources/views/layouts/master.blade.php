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
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/LOGO_VENTANA_SF.png') }}">

    <!-- Librerías externas -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          integrity="sha512-..."
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />

    {{-- Vite: Carga de estilos y scripts principales --}}
    @vite([
        'resources/scss/bootstrap.scss',
        'resources/scss/icons.scss',
        'resources/scss/app.scss',
        'resources/scss/custom.scss',
        'resources/js/app.js'
    ])

    {{-- CSS o JS adicionales de cada vista --}}
    @yield('css')
</head>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;

    // Cargar preferencia previa
    if (localStorage.getItem('theme') === 'dark') {
        html.classList.add('dark');
    }

    const darkToggle = document.getElementById('dark-toggle');
    if (darkToggle) {
        darkToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });
    }
});
</script>




<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        
        @include('layouts.sidebar')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content" style="margin-left: 250px;">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
    @yield('scripts')
</body>

</html>

