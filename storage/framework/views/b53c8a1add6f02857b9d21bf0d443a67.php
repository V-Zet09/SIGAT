

<?php $__env->startSection('title', 'Detalle de Actividad'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Detalle de Actividad</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Título:</strong> <?php echo e($actividad->titulo); ?></p>
            <p><strong>Autor:</strong> <?php echo e($actividad->autor ?? 'Anónimo'); ?></p>
            <p><strong>Fecha:</strong> <?php echo e(\Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y')); ?></p>
            <p><strong>Área:</strong> <?php echo e($actividad->tipo_area); ?></p>
            <p><strong>Resumen:</strong> <?php echo e($actividad->resumen); ?></p>
            <p><strong>Contenido:</strong> <?php echo nl2br(e($actividad->contenido)); ?></p>
            <p><strong>Presupuesto:</strong> $<?php echo e(number_format($actividad->presupuesto, 2)); ?></p>
            <p><strong>Tipo de Presupuesto:</strong> <?php echo e($actividad->tipo_presupuesto); ?></p>
            <p><strong>Archivo:</strong>
                <?php if($actividad->foto): ?>
                    <img src="<?php echo e(asset('storage/' . $actividad->foto)); ?>" alt="Foto de actividad" class="img-fluid mb-2">
                    <br>
                    <a href="<?php echo e(asset('storage/' . $actividad->foto)); ?>" target="_blank">Ver archivo</a>
                <?php else: ?>
                    No adjunto
                <?php endif; ?>

            </p>
            <a href="<?php echo e(route('actividades.registradas')); ?>" class="btn btn-secondary mt-3">← Volver</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\zaet_\OneDrive\Escritorio\AYUNTAMIENTO\resources\views/show.blade.php ENDPATH**/ ?>