@extends('layouts.master')
@section('title')
    Auxiliar de Area
@endsection
@section('css')
    <!--Swiper slider css-->
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- jsvectormap css -->
    <link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            BIENVENIDO DARK 
        @endslot
    @endcomponent

    <div class="row dash-nft">
        <div class="row mt-4">
    <!-- Actividades registradas -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-secondary text-white text-center rounded-top-4">
                <h5 class="mb-0">📌 Actividades Registradas</h5>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad registrada 1
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-primary rounded-pill">Ver detalles</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad registrada 2
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-primary rounded-pill">Ver detalles</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad registrada 3
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-primary rounded-pill">Ver detalles</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Actividades en revisión -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark text-center rounded-top-4">
                <h5 class="mb-0">🔍 Actividades en Revisión</h5>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad en revisión 1
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-warning rounded-pill text-dark">Ver detalles</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad en revisión 2
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-warning rounded-pill text-dark">Ver detalles</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad en revisión 3
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-warning rounded-pill text-dark">Ver detalles</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Actividades aprobadas -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-success text-white text-center rounded-top-4">
                <h5 class="mb-0">✅ Actividades Aprobadas</h5>
            </div>
            <div class="card-body bg-light rounded-bottom-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad aprobada 1
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-success rounded-pill">Ver detalles</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad aprobada 2
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-success rounded-pill">Ver detalles</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Actividad aprobada 3
                        <a href="apps-tasks-details" class="btn btn-sm btn-outline-success rounded-pill">Ver detalles</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!-- Countdown js -->
    <script src="{{ URL::asset('build/js/pages/coming-soon.init.js') }}"></script>

    <!-- Marketplace init -->
    <script src="{{ URL::asset('build/js/pages/dashboard-nft.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
