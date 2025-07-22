
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.analytics'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        
        .dashboard-card h4 {
            font-size: 18px;
            color: #444;
            margin-bottom: 15px;
        }
        
        .dashboard-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .dashboard-card .highlight {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin: 15px 0;
        }
        
        .search-box {
            padding: 15px;
            display: flex;
            align-items: center;
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .divider {
            height: 1px;
            background-color: #eee;
            margin: 20px 0;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboards
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            ¡Hola, Administrador!
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <h4>4 actividades registradas</h4>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>Total orders</h4>
                <p>Last: 7 days</p>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>Completed</h4>
                <p>Pending payment</p>
            </div>
        </div>
        
        <div class="col-xl-6 col-md-12">
            <div class="dashboard-card search-box">
                <input type="text" placeholder="Buscar...">
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>4 actividades en revisión</h4>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <div class="highlight">16,247</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>Actividades por área</h4>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>4 usuarios activos</h4>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="dashboard-card">
                <h4>2025</h4>
                <div class="highlight">45 actividades registradas</div>
            </div>
        </div>
    </div>

    <!-- Manteniendo tus secciones originales -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Actividades reguladas</h4>
                    <ul class="list-unstyled">
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> Actividades reguladas</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> Actividades en revistas</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> Usuarios activos</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> 2023 a actividades reguladas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Título anterior</h4>
                    <p class="text-muted mb-0">Lleva 7 años</p>
                    
                    <div class="mt-4">
                        <h4 class="card-title mb-4">Cumplido</h4>
                        <p class="text-muted">Puedes presentar</p>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="card-title mb-4">Aprobación con área</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Descripción reservada (Vocupado de Tutorios) 2024/2025</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th>Actividades</th>
                                    <th>Usuarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Enero</td>
                                    <td>120</td>
                                    <td>85</td>
                                </tr>
                                <tr>
                                    <td>Febrero</td>
                                    <td>150</td>
                                    <td>92</td>
                                </tr>
                                <tr>
                                    <td>Marzo</td>
                                    <td>180</td>
                                    <td>110</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="text-center text-muted">
                © Derechos reservados Municipio de Tlapehuala 2024/2027
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/jsvectormap/maps/world-merc.js')); ?>"></script>

    <!-- dashboard init -->
    <script src="<?php echo e(URL::asset('build/js/pages/dashboard-analytics.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Maria\Documents\GitHub\SIGAT\resources\views/dashboard-analytics.blade.php ENDPATH**/ ?>