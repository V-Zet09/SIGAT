

<?php $__env->startSection('title', 'Editar Actividad'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Editar Actividad</h2>

    <form action="<?php echo e(route('actividades.update', $actividad->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="<?php echo e(old('titulo', $actividad->titulo)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" name="autor" class="form-control" value="<?php echo e(old('autor', $actividad->autor)); ?>">
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="<?php echo e(old('fecha', $actividad->fecha)); ?>">
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Área</label>
            <select name="tipo_area" id="tipo_area" class="form-select">
                        <option value="Informatica">Informática</option>
                        <option value="Regidores">Regidores</option>
                        <option value="Tesoreria">Tesorería</option>
                    </select>
            </div>

        <div class="mb-3">
            <label for="tipo_actividad" class="form-label">Tipo de Actividad</label>
            <input type="text" name="tipo_actividad" class="form-control" value="<?php echo e(old('tipo_actividad', $actividad->tipo_actividad)); ?>">
        </div>

        <div class="mb-3">
            <label for="resumen" class="form-label">Resumen</label>
            <textarea name="resumen" class="form-control" rows="3"><?php echo e(old('resumen', $actividad->resumen)); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" class="form-control" rows="5"><?php echo e(old('contenido', $actividad->contenido)); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="presupuesto" class="form-label">Presupuesto</label>
            <input type="number" name="presupuesto" class="form-control" value="<?php echo e(old('presupuesto', $actividad->presupuesto)); ?>">
        </div>

        <div class="mb-3">
            <label for="tipo_presupuesto" class="form-label">Tipo de Presupuesto</label>
             <select name="tipo_presupuesto" id="tipo_presupuesto" class="form-select">
                        <option value="Municipal">Municipal</option>
                        <option value="Estatal">Estatal</option>
                        <option value="Federal">Federal</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?php echo e(route('actividades.registradas')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\zaet_\OneDrive\Escritorio\AYUNTAMIENTO\resources\views/edit.blade.php ENDPATH**/ ?>