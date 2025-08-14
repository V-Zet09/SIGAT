

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
            <input type="text" name="area" class="form-control" value="<?php echo e(old('area', $actividad->area)); ?>">
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
            <input type="text" name="tipo_presupuesto" class="form-control" value="<?php echo e(old('tipo_presupuesto', $actividad->tipo_presupuesto)); ?>">
        </div>

        <div class="mb-3">
            <label for="municipio" class="form-label">Municipio</label>
            <input type="text" name="municipio" class="form-control" value="<?php echo e(old('municipio', $actividad->municipio)); ?>">
        </div>

        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo (opcional)</label>
            <input type="file" name="archivo" class="form-control">
            <?php if($actividad->archivo): ?>
                <small class="text-muted">Archivo actual: <a href="<?php echo e(asset('storage/' . $actividad->archivo)); ?>" target="_blank">Ver archivo</a></small>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?php echo e(route('actividades.registradas')); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\SIGAT\resources\views/edit.blade.php ENDPATH**/ ?>