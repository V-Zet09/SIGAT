

<?php $__env->startSection('title', 'Actividades'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/glightbox/css/glightbox.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $hoy = date('Y-m-d');
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Registrar Nueva Actividad</h4>
        </div>
        <div class="card-body">
            
            <div id="alerta-fecha" class="alert alert-warning d-none" role="alert">
                ⚠️ No puedes registrar una actividad con fecha futura.
            </div>

            <form action="<?php echo e(route('actividades.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" name="autor" id="autor" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" max="<?php echo e($hoy); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tipo_area" class="form-label">Tipo de área</label>
                    <select name="tipo_area" id="tipo_area" class="form-select">
                        <option value="Informatica">Informática</option>
                        <option value="Regidores">Regidores</option>
                        <option value="Tesoreria">Tesorería</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="resumen" class="form-label">Resumen</label>
                    <textarea name="resumen" id="resumen" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea name="contenido" id="contenido" class="form-control" rows="5"></textarea>
                </div>

                <div class="mb-3">
                    <label for="presupuesto" class="form-label">Presupuesto</label>
                    <input type="number" name="presupuesto" id="presupuesto" class="form-control" step="0.01">
                </div>

                <div class="mb-3">
                    <label for="tipo_presupuesto" class="form-label">Tipo de Presupuesto</label>
                    <select name="tipo_presupuesto" id="tipo_presupuesto" class="form-select">
                        <option value="Municipal">Municipal</option>
                        <option value="Estatal">Estatal</option>
                        <option value="Federal">Federal</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInput = document.getElementById('fecha');
        const alerta = document.getElementById('alerta-fecha');

        fechaInput.addEventListener('input', function () {
            const valor = this.value;
            const fechaIngresada = new Date(valor);
            const hoy = new Date();

            fechaIngresada.setHours(0, 0, 0, 0);
            hoy.setHours(0, 0, 0, 0);

            if (fechaIngresada > hoy) {
                alerta.classList.remove('d-none');
                this.value = '';
            } else {
                alerta.classList.add('d-none');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\SIGAT\resources\views/dashboard-actividades.blade.php ENDPATH**/ ?>