
<?php $__env->startSection('title', 'Director de Área'); ?>
    
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Inicio
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Bienvenido Director 
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row project-wrapper">
        <div class="row mt-4">
    <!-- Actividades por revisar -->
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white text-center">
                Actividades por revisar 🔍
            </div>
            <div class="card-body bg-light" id="pending-activities">
                <!-- Actividad 1 -->
                <div class="activity-item d-flex align-items-center justify-content-between mb-2 p-2 bg-success text-white rounded">
                    <span>La comida del guero</span>
                    <span>
                        <i class="ri-eye-line" style="cursor: pointer;" onclick="toggleDetails(this)"></i>
                        <i class="ri-checkbox-line" style="cursor: pointer;" onclick="confirmApproval(this)"></i>
                    </span>
                </div>
                <div class="activity-details text-dark mb-3" style="display: none;">
                    <ul>
                        <li>Arroz</li>
                        <li>Leche</li>
                        <li>Pastel</li>
                    </ul>
                </div>

                <!-- Actividad 2 -->
                <div class="activity-item d-flex align-items-center justify-content-between mb-2 p-2 bg-success text-white rounded">
                    <span>Fotos del travis</span>
                    <span>
                        <i class="ri-eye-line" style="cursor: pointer;" onclick="toggleDetails(this)"></i>
                        <i class="ri-checkbox-line" style="cursor: pointer;" onclick="confirmApproval(this)"></i>
                    </span>
                </div>
                <div class="activity-details text-dark mb-3" style="display: none;">
                    <ul>
                        <li>En el río</li>
                        <li>En el restaurant Los Pericos</li>
                        <li>En la Morelos</li>
                    </ul>
                </div>

                <!-- Actividad 3 -->
                <div class="activity-item d-flex align-items-center justify-content-between mb-2 p-2 bg-success text-white rounded">
                    <span>Perfil de facebook de Faustino lopez alonso</span>
                    <span>
                        <i class="ri-eye-line" style="cursor: pointer;" onclick="toggleDetails(this)"></i>
                        <i class="ri-checkbox-line" style="cursor: pointer;" onclick="confirmApproval(this)"></i>
                    </span>
                </div>
                <div class="activity-details text-dark mb-3" style="display: none;">
                    <ul>
                        <li>Amigos agregados</li>
                        <li>Fotos</li>
                        <li>Relación sentimental</li>
                    </ul>
                </div>

                <!-- Actividad 4 -->
                <div class="activity-item d-flex align-items-center justify-content-between mb-2 p-2 bg-success text-white rounded">
                    <span>Voli 2</span>
                    <span>
                        <i class="ri-eye-line" style="cursor: pointer;" onclick="toggleDetails(this)"></i>
                        <i class="ri-checkbox-line" style="cursor: pointer;" onclick="confirmApproval(this)"></i>
                    </span>
                </div>
                <div class="activity-details text-dark mb-3" style="display: none;">
                    <ul>
                        <li>Juego en la cancha municipal</li>
                        <li>Resultado: 2 - 0</li>
                    </ul>
                </div>

                <!-- Actividad 5 -->
                <div class="activity-item d-flex align-items-center justify-content-between mb-2 p-2 bg-success text-white rounded">
                    <span>Torneo FIFA Ayuntamiento Tlapehuala</span>
                    <span>
                        <i class="ri-eye-line" style="cursor: pointer;" onclick="toggleDetails(this)"></i>
                        <i class="ri-checkbox-line" style="cursor: pointer;" onclick="confirmApproval(this)"></i>
                    </span>
                </div>
                <div class="activity-details text-dark mb-3" style="display: none;">
                    <ul>
                        <li>Participantes: 12 equipos</li>
                        <li>Duración: 1 semana</li>
                    </ul>
                </div>

                <!-- Actividad 6 -->
                <div class="activity-item d-flex align-items-center justify-content-between mb-2 p-2 bg-success text-white rounded">
                    <span>Registrar equipo de voleibol en VNL con los jóvenes de Educación Dual contando con la superestrella Joshep Angelo Alphonso Lion</span>
                    <span>
                        <i class="ri-eye-line" style="cursor: pointer;" onclick="toggleDetails(this)"></i>
                        <i class="ri-checkbox-line" style="cursor: pointer;" onclick="confirmApproval(this)"></i>
                    </span>
                </div>
                <div class="activity-details text-dark mb-3" style="display: none;">
                    <ul>
                        <li>Inscripción confirmada</li>
                        <li>Entrenamientos en curso</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividades aprobadas -->
    <div class="col-md-6">
        <div class="card border-info">
            <div class="card-header bg-info text-white text-center">
                Actividades aprobadas ✅
            </div>
            <div class="card-body bg-light" id="approved-activities">
                <!-- Aquí se moverán las actividades aprobadas -->
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
function toggleDetails(icon) {
    const details = icon.closest('.d-flex').nextElementSibling;
    if (details.style.display === 'none') {
        details.style.display = 'block';
        icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
    } else {
        details.style.display = 'none';
        icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
    }
}

function confirmApproval(icon) {
    if (confirm("¿Estás seguro de marcar esta actividad como aprobada?")) {
        moveToApproved(icon);
    }
}

function moveToApproved(icon) {
    const activity = icon.closest('.activity-item');
    const details = activity.nextElementSibling;

    // Eliminar la palomita (dejando el ícono de ojo)
    icon.remove();

    // Mover actividad y detalles al recuadro de aprobadas
    const approvedContainer = document.getElementById('approved-activities');
    approvedContainer.appendChild(activity);
    approvedContainer.appendChild(details);

    // Cambiar el color del recuadro al aprobar
    activity.classList.remove('bg-success');
    activity.classList.add('bg-secondary');
}
</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/dashboard-projects.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jorge\OneDrive\Documentos\GitHub\SIGAT\resources\views/dashboard-projects.blade.php ENDPATH**/ ?>