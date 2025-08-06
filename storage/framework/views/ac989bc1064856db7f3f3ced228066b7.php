<?php
    // Simulación de datos para el dashboard del presidente
    $totalActividades = 120;
    $actividadesSemana = 14;
    $aprobadas = 89;
    $revision = 31;
    $departamentosSinActividad = 3;

    $actividadesPorMes = [
        'Enero' => 10,
        'Febrero' => 12,
        'Marzo' => 15,
        'Abril' => 20,
        'Mayo' => 18,
        'Junio' => 25,
        'Julio' => 20
];
    $actividadesPorDia = [
        'Lunes' => ['aprobadas' => 6, 'revision' => 3],
        'Martes' => ['aprobadas' => 8, 'revision' => 2],
        'Miércoles' => ['aprobadas' => 5, 'revision' => 4],
        'Jueves' => ['aprobadas' => 10, 'revision' => 1],
        'Viernes' => ['aprobadas' => 7, 'revision' => 3],
        'Sábado' => ['aprobadas' => 4, 'revision' => 6],
        'Domingo' => ['aprobadas' => 9, 'revision' => 0],
    ];
?>




<?php $__env->startSection('title', 'Presidente Municipal'); ?>
<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Dashboards <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> BIENVENIDO PRESIDENTE <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">

                        <!-- Total de actividades -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total de Actividades</h5>
                                <div class="d-flex align-items-center">
                                    <i class="ri-file-list-3-line display-6 text-muted"></i>
                                    <h2 class="mb-0 ms-3"><?php echo e($totalActividades); ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Actividades esta semana -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Esta Semana</h5>
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-check-line display-6 text-muted"></i>
                                    <h2 class="mb-0 ms-3"><?php echo e($actividadesSemana); ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Aprobadas -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Aprobadas</h5>
                                <div class="d-flex align-items-center">
                                    <i class="ri-checkbox-circle-line display-6 text-muted"></i>
                                    <h2 class="mb-0 ms-3"><?php echo e($aprobadas); ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- En revisión -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">En Revisión</h5>
                                <div class="d-flex align-items-center">
                                    <i class="ri-loader-line display-6 text-muted"></i>
                                    <h2 class="mb-0 ms-3"><?php echo e($revision); ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Departamentos sin actividad -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Deptos. sin Actividad</h5>
                                <div class="d-flex align-items-center">
                                    <i class="ri-alert-line display-6 text-muted"></i>
                                    <h2 class="mb-0 ms-3"><?php echo e($departamentosSinActividad); ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                        </div><!-- end col -->
      
                    </div><!-- end row -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
<!-- grafico -->
    <div class="card mt-0">
        <div class="card-header">
            <h4 class="card-title mb-0">Actividades Registradas por Departamento</h4>
        </div>
        <div class="card-body px-3">
            <div id="grafica-actividades-departamento"></div>
        </div>
    </div>

    <div class="card mt-4">
    <div class="card-header">
        <h4 class="card-title mb-0">Actividades Aprobadas vs En Revisión (Últimos 7 días)</h4>
    </div>
    <div class="card-body">
        <div id="grafica-aprobadas-revision-semana"></div>
    </div>
    </div>





    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Departamentos sin actividades registradas</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">02 Nov 2021 to 31 Dec 2021<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Today</a>
                                <a class="dropdown-item" href="#">Last Week</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                                <a class="dropdown-item" href="#">Current Year</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-hover table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-muted">
                                    <th scope="col">Departamento</th>
                                    <th scope="col" style="width: 20%;">Última actividad</th>
                                    <th scope="col">Encargado</th>
                                    <th scope="col" style="width: 16%;">Estatus</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Tesorería</td>
                                    <td>Sep 20, 2024</td>
                                    <td><img src="<?php echo e(URL::asset('build/images/users/avatar-1.jpg')); ?>" alt="" class="avatar-xs rounded-circle me-2 material-shadow">
                                        <a href="#javascript: void(0);" class="text-body fw-medium">Donald Risher</a>
                                    </td>
                                    <td><span class="badge bg-success-subtle text-success p-2">Deal Won</span></td>
                        
                                </tr>
                                <tr>
                                    <td>Oficialía Mayor</td>
                                    <td>Ene 23, 2025</td>
                                    <td><img src="<?php echo e(URL::asset('build/images/users/avatar-2.jpg')); ?>" alt="" class="avatar-xs rounded-circle me-2 material-shadow">
                                        <a href="#javascript: void(0);" class="text-body fw-medium">Sofia Cunha</a>
                                    </td>
                                    <td><span class="badge bg-warning-subtle text-warning p-2">Intro Call</span></td>

                                </tr>
                                <tr>
                                    <td>Registro Civil</td>
                                    <td>Feb 27, 2025</td>
                                    <td><img src="<?php echo e(URL::asset('build/images/users/avatar-3.jpg')); ?>" alt="" class="avatar-xs rounded-circle me-2 material-shadow">
                                        <a href="#javascript: void(0);" class="text-body fw-medium">Luis Rocha</a>
                                    </td>
                                    <td><span class="badge bg-danger-subtle text-danger p-2">Stuck</span></td>

                                </tr>
                                <tr>
                                    <td>Desarrollo económico</td>
                                    <td>May 30, 2025</td>
                                    <td><img src="<?php echo e(URL::asset('build/images/users/avatar-4.jpg')); ?>" alt="" class="avatar-xs rounded-circle me-2 material-shadow">
                                        <a href="#javascript: void(0);" class="text-body fw-medium">Vitoria Rodrigues</a>
                                    </td>
                                    <td><span class="badge bg-success-subtle text-success p-2">Deal Won</span></td>

                                </tr>
                                <tr>
                                    <td>Contraloría</td>
                                    <td>Abr 30, 2025</td>
                                    <td><img src="<?php echo e(URL::asset('build/images/users/avatar-6.jpg')); ?>" alt="" class="avatar-xs rounded-circle me-2 material-shadow">
                                        <a href="#javascript: void(0);" class="text-body fw-medium">Vitoria Rodrigues</a>
                                    </td>
                                    <td><span class="badge bg-info-subtle text-info p-2">New Lead</span></td>

                                </tr>
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end table responsive -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Actividades',
                data: [7, 2, 10, 8, 2, 4, 2]
            }],
            xaxis: {
                categories: ['Obras Públicas', 'Informática', 'DIF', 'Tránsito', 'Agua potable', 'Alumbrado público', 'Eventos especiales']
            },
            colors: ['#27768a']
        };

        const chart = new ApexCharts(document.querySelector("#grafica-actividades-departamento"), options);
        chart.render();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const actividades = <?php echo json_encode($actividadesPorDia, 15, 512) ?>;

        const dias = Object.keys(actividades);
        const aprobadas = dias.map(dia => actividades[dia].aprobadas);
        const revision = dias.map(dia => actividades[dia].revision);

        const options = {
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    borderRadius: 4
                }
            },
            colors: ['#748d44', '#f0f5e2'], // azul fuerte y azul claro
            series: [
                {
                    name: 'Aprobadas',
                    data: aprobadas
                },
                {
                    name: 'En revisión',
                    data: revision
                }
            ],
            xaxis: {
                categories: dias,
                title: { text: 'Día' }
            },
            yaxis: {
                title: { text: 'Actividades' }
            },
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: false
            },
        };

        const chart = new ApexCharts(document.querySelector("#grafica-aprobadas-revision-semana"), options);
        chart.render();
    });
</script>

    <script src="<?php echo e(URL::asset('build/js/pages/dashboard-crm.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jorge\OneDrive\Documentos\GitHub\SIGAT\resources\views/dashboard-crm.blade.php ENDPATH**/ ?>