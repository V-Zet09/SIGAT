@extends('layouts.master')
@section('title', 'Regidor')
@section('css')

    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

@endsection
@section('content')

    @component('components.breadcrumb')
    @slot('li_1') Panel de Control @endslot
    @slot('title') Bienvenido Síndico Procurador @endslot
@endcomponent

<div class="row g-3 mb-3">
    <!-- Total Actividades -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-file-list-3-line fs-2 mb-2"></i>
                <h6>Total de Actividades</h6>
                <h3>{{ $totalActividades }}</h3>
            </div>
        </div>
    </div>

    <!-- Esta Semana -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-calendar-check-line fs-2 mb-2"></i>
                <h6>Esta Semana</h6>
                <h3>{{ $actividadesSemana }}</h3>
            </div>
        </div>
    </div>

    <!-- Aprobadas -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-checkbox-circle-line fs-2 mb-2"></i>
                <h6>Aprobadas</h6>
                <h3>{{ $aprobadas }}</h3>
            </div>
        </div>
    </div>

    <!-- En Revisión -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-loader-line fs-2 mb-2"></i>
                <h6>En Revisión</h6>
                <h3>{{ $revision }}</h3>
            </div>
        </div>
    </div>

    <!-- Sin Actividad -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #e57373;">
            <div class="card-body text-center text-white">
                <i class="ri-alert-line fs-2 mb-2"></i>
                <h6>Sin Actividad</h6>
                <h3>{{ $departamentosSinActividad }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Gráfica de actividades por departamento -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white">
        <h4 class="mb-0 text-success">Actividades por Departamento</h4>
    </div>
    <div class="card-body">
        <div id="grafica-actividades-departamento"></div>
    </div>
</div>

<!-- Gráfica Aprobadas vs Revisión -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white">
        <h4 class="mb-0 text-success">Aprobadas vs Revisión (7 días)</h4>
    </div>
    <div class="card-body">
        <div id="grafica-aprobadas-revision-semana"></div>
    </div>
</div>

<!-- Tabla de Departamentos sin actividad -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h4 class="mb-0 text-success">Departamentos sin actividades</h4>
        <small class="text-muted">Rango: 02 Nov 2021 - 31 Dic 2021</small>
    </div>
    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-hover align-middle">
                <thead class="table-light text-success">
                    <tr>
                        <th>Departamento</th>
                        <th>Última Actividad</th>
                        <th>Encargado</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ([
                        ['Tesorería', 'Sep 20, 2024', 'avatar-1.jpg', 'Donald Risher', 'Deal Won', 'success'],
                        ['Oficialía Mayor', 'Ene 23, 2025', 'avatar-2.jpg', 'Sofia Cunha', 'Intro Call', 'warning'],
                        ['Registro Civil', 'Feb 27, 2025', 'avatar-3.jpg', 'Luis Rocha', 'Stuck', 'danger'],
                        ['Desarrollo Económico', 'May 30, 2025', 'avatar-4.jpg', 'Vitoria Rodrigues', 'Deal Won', 'success'],
                        ['Contraloría', 'Abr 30, 2025', 'avatar-6.jpg', 'Vitoria Rodrigues', 'New Lead', 'info']
                    ] as $item)
                    <tr>
                        <td>{{ $item[0] }}</td>
                        <td>{{ $item[1] }}</td>
                        <td>
                            <img src="{{ URL::asset('build/images/users/' . $item[2]) }}" alt="" class="avatar-xs rounded-circle me-2">
                            <a href="#" class="text-body fw-medium">{{ $item[3] }}</a>
                        </td>
                        <td><span class="badge bg-{{ $item[5] }}-subtle text-{{ $item[5] }} p-2">{{ $item[4] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        new ApexCharts(document.querySelector("#grafica-actividades-departamento"), {
            chart: { type: 'bar', height: 350 },
            series: [{
                name: 'Actividades',
                data: [7, 2, 10, 8, 2, 4, 2]
            }],
            xaxis: {
                categories: ['Obras Públicas', 'Informática', 'DIF', 'Tránsito', 'Agua Potable', 'Alumbrado', 'Eventos']
            },
            colors: ['#748d44']
        }).render();
    });

    document.addEventListener("DOMContentLoaded", function () {
        const actividades = @json($actividadesPorDia);
        const dias = Object.keys(actividades);
        const aprobadas = dias.map(d => actividades[d].aprobadas);
        const revision = dias.map(d => actividades[d].revision);

        new ApexCharts(document.querySelector("#grafica-aprobadas-revision-semana"), {
            chart: { type: 'bar', height: 350, stacked: true, toolbar: { show: false } },
            series: [
                { name: 'Aprobadas', data: aprobadas },
                { name: 'En revisión', data: revision }
            ],
            colors: ['#748d44', '#f0f5e2'],
            xaxis: { categories: dias },
            legend: { position: 'bottom' }
        }).render();
    });
</script>

<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
