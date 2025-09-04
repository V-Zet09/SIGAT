

<?php $__env->startSection('title', 'Actividades Registradas'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/glightbox/css/glightbox.min.css')); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .btn-square {
        width: 48px;
        height: 48px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Actividades Registradas</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('actividades.registradas')); ?>" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar actividad" value="<?php echo e(request('buscar')); ?>">
        </div>
        <div class="col-md-4">
            <select name="tipo_area" class="form-select">
                <option value="">Filtrar por: Área</option>
                <?php $__currentLoopData = [
                    'Agua potable',
                    'Bienestar Social y Desarrollo Rural',
                    'Catastro',
                    'Contraloria Interna',
                    'Deportes',
                    'DIF',
                    'Informática',
                    'Limpia',
                    'Obras Publicas',
                    'Oficialia Mayor',
                    'Presidencia',
                    'Recursos Humanos',
                    'Registro Civil',
                    'Regidores',
                    'Reglamentos',
                    'Secretaria General',
                    'Seguridad Publica',
                    'Sindicatura',
                    'Tesoreria',
                    'Transito'
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($opcion); ?>" <?php echo e(request('tipo_area') == $opcion ? 'selected' : ''); ?>><?php echo e($opcion); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('actividades.registradas')); ?>" class="btn btn-outline-light">
        Limpiar filtros
    </a>
    <a href="<?php echo e(route('actividades.create')); ?>" class="btn btn-success">
        Crear Actividad
    </a>
        </div>
    </form>

    
    <?php if($actividades->count()): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Fecha</th>
                        <th>Área</th>
                        <th>Resumen</th>
                        <th>Contenido</th>
                        <th>Presupuesto</th>
                        <th>Tipo de Presupuesto</th>
                        <th>Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($actividad->titulo); ?></td>
                            <td><?php echo e($actividad->autor ?? 'Anónimo'); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y')); ?></td>
                            <td><?php echo e($actividad->tipo_area ?? 'Sin área'); ?></td>
                            <td>
                                <?php echo e(Str::limit($actividad->resumen, 80, '...')); ?>

                                <?php if(strlen($actividad->resumen) > 80): ?>
                                    <a href="<?php echo e(route('actividades.show', $actividad->id)); ?>" class="text-primary ms-1">Ver más</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e(Str::limit($actividad->contenido, 80, '...')); ?>

                                <?php if(strlen($actividad->contenido) > 80): ?>
                                    <a href="<?php echo e(route('actividades.show', $actividad->id)); ?>" class="text-primary ms-1">Ver más</a>
                                <?php endif; ?>
                            </td>
                            <td>$<?php echo e(number_format($actividad->presupuesto, 2)); ?></td>
                            <td><?php echo e($actividad->tipo_presupuesto ?? 'N/A'); ?></td>
                            <td>
                                <?php if($actividad->foto): ?>
                                    <a href="<?php echo e(asset('storage/' . $actividad->foto)); ?>" target="_blank">Ver imagen</a>
                                <?php else: ?>
                                    No adjunto
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo e(route('actividades.show', $actividad->id)); ?>" class="btn btn-outline-primary btn-square" title="Ver">
                                        <i class="fas fa-eye fa-lg"></i>
                                    </a>
                                    <a href="<?php echo e(route('actividades.edit', $actividad->id)); ?>" class="btn btn-outline-success btn-square" title="Editar">
                                        <i class="fas fa-pencil-alt fa-lg"></i>
                                    </a>
                                    <form action="<?php echo e(route('actividades.destroy', $actividad->id)); ?>" method="POST" onsubmit="return confirm('⚠️ Esta acción eliminará la actividad permanentemente.\n\n¿Estás seguro de continuar?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-outline-danger btn-square" title="Eliminar">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Mostrando <?php echo e($actividades->firstItem()); ?> a <?php echo e($actividades->lastItem()); ?> de <?php echo e($actividades->total()); ?> actividades
            </div>
            <div>
                <?php echo e($actividades->appends(request()->query())->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            No se encontraron actividades con los filtros aplicados.
        </div>
    <?php endif; ?>
</div>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action="<?php echo e(route('actividades.registradas')); ?>"]');
        const buscarInput = form.querySelector('input[name="buscar"]');
        const tipoAreaSelect = form.querySelector('select[name="tipo_area"]');

        // Enviar automáticamente al cambiar el select
        tipoAreaSelect.addEventListener('change', () => {
            form.submit();
        });

        // Enviar automáticamente al escribir en el input (con retardo)
        let timer;
        buscarInput.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                form.submit();
            }, 600); // Espera 600ms después de dejar de escribir
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Documents\GitHub\SIGAT\resources\views/dashboard-actividades-registradas.blade.php ENDPATH**/ ?>