<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-topbar="light"
      data-sidebar-image="none"
      data-theme="default"
      data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') - Inicio Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ URL::asset('images/LOGO_VENTANA_SF.png') }}">

    @include('layouts.head-css')

    {{-- Vite para estilos y scripts principales --}}
    @vite([
        'resources/scss/bootstrap.scss',
        'resources/scss/icons.scss',
        'resources/scss/app.scss',
        'resources/scss/custom.scss',
        'resources/js/app.js'
    ])
</head>

<body>
    @yield('body')
    @yield('content')

    @include('layouts.vendor-scripts')
</body>
</html>
