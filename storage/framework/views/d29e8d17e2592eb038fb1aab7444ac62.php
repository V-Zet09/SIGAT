<?php $__env->startSection('title', 'Regidor'); ?>
<?php $__env->startSection('css'); ?>

    <link href="<?php echo e(URL::asset('build/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Panel de Control <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Bienvenido Síndico Procurador <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row g-3 mb-3">
    <!-- Total Actividades -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-file-list-3-line fs-2 mb-2"></i>
                <h6>Total de Actividades</h6>
                <h3><?php echo e($totalActividades); ?></h3>
            </div>
        </div>
    </div>

    <!-- Esta Semana -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-calendar-check-line fs-2 mb-2"></i>
                <h6>Esta Semana</h6>
                <h3><?php echo e($actividadesSemana); ?></h3>
            </div>
        </div>
    </div>

    <!-- Aprobadas -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-checkbox-circle-line fs-2 mb-2"></i>
                <h6>Aprobadas</h6>
                <h3><?php echo e($aprobadas); ?></h3>
            </div>
        </div>
    </div>

    <!-- En Revisión -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #748d44;">
            <div class="card-body text-center text-white">
                <i class="ri-loader-line fs-2 mb-2"></i>
                <h6>En Revisión</h6>
                <h3><?php echo e($revision); ?></h3>
            </div>
        </div>
    </div>

    <!-- Sin Actividad -->
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm" style="background-color: #e57373;">
            <div class="card-body text-center text-white">
                <i class="ri-alert-line fs-2 mb-2"></i>
                <h6>Sin Actividad</h6>
                <h3><?php echo e($departamentosSinActividad); ?></h3>
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
                    <?php $__currentLoopData = [
                        ['Tesorería', 'Sep 20, 2024', 'avatar-1.jpg', 'Donald Risher', 'Deal Won', 'success'],
                        ['Oficialía Mayor', 'Ene 23, 2025', 'avatar-2.jpg', 'Sofia Cunha', 'Intro Call', 'warning'],
                        ['Registro Civil', 'Feb 27, 2025', 'avatar-3.jpg', 'Luis Rocha', 'Stuck', 'danger'],
                        ['Desarrollo Económico', 'May 30, 2025', 'avatar-4.jpg', 'Vitoria Rodrigues', 'Deal Won', 'success'],
                        ['Contraloría', 'Abr 30, 2025', 'avatar-6.jpg', 'Vitoria Rodrigues', 'New Lead', 'info']
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item[0]); ?></td>
                        <td><?php echo e($item[1]); ?></td>
                        <td>
                            <img src="<?php echo e(URL::asset('build/images/users/' . $item[2])); ?>" alt="" class="avatar-xs rounded-circle me-2">
                            <a href="#" class="text-body fw-medium"><?php echo e($item[3]); ?></a>
                        </td>
                        <td><span class="badge bg-<?php echo e($item[5]); ?>-subtle text-<?php echo e($item[5]); ?> p-2"><?php echo e($item[4]); ?></span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>

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
        const actividades = <?php echo json_encode($actividadesPorDia, 15, 512) ?>;
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

<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Ayuntamiento\SIGAT-main\resources\views/dashboard-regidor.blade.php ENDPATH**/ ?>