

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.password-reset'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<style>
    :root {
        --primary-blue: #2776BA;
        --secondary-blue: #5490AA;
        --light-blue: #7480AA;
        --accent-wine: #854256;
        --card-bg: rgba(255, 255, 255, 0.95);
    }
    
    .bg-persianas-gruesas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(
                90deg,
                rgba(255,255,255,0.15) 0%,
                rgba(255,255,255,0) 10%,
                rgba(255,255,255,0) 90%,
                rgba(255,255,255,0.15) 100%
            ),
            url('<?php echo e(asset('images/fondo.jpeg')); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -1;
        opacity: 0.9;
        mask-image: repeating-linear-gradient(
            90deg,
            transparent 0px,
            transparent 15px,       <!-- Espacio transparente reducido -->
            rgba(0,0,0,0.8) 15px,  <!-- Persianas más gruesas -->
            rgba(0,0,0,0.8) 60px   <!-- Ancho aumentado -->
        );
        -webkit-mask-image: repeating-linear-gradient(
            90deg,
            transparent 0px,
            transparent 15px,
            rgba(0,0,0,0.8) 15px,
            rgba(0,0,0,0.8) 60px
        );
    }
    
    .compact-card {
        max-width: 480px;
        padding: 1.75rem;
        border-radius: 12px;
        backdrop-filter: blur(6px);
        background-color: var(--card-bg);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.35);
    }
</style>

<div class="auth-page-wrapper pt-4 position-relative" style="min-height: 100vh;">
    
    <!-- Fondo con persianas gruesas -->
    <div class="bg-persianas-gruesas"></div>
    
    <!-- Contenido compacto -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="compact-card shadow-sm">
            <div class="text-center">
                <h4 class="text-primary fw-bold mb-2">¿Olvidaste tu contraseña?</h4>
                <p class="mb-3" style="color: var(--secondary-blue);">Solicita el restablecimiento de tu acceso al sistema SIGAT</p>
                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#2776BA" style="width:80px;height:80px;"></lord-icon>
            </div>

            <div class="alert alert-warning text-start py-2 mb-3">
                <i class="fas fa-info-circle me-2"></i> Ingresa tu correo electrónico registrado y sigue las instrucciones enviadas.
            </div>

            <?php if(session('status')): ?>
                <div class="alert alert-success text-center py-2 mb-3">
                    <i class="fas fa-check-circle me-2"></i> <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('password.email')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: var(--secondary-blue); font-weight: 500;">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control py-2 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Ingresa tu correo electrónico" value="<?php echo e(old('email')); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary py-2">
                        <i class="fas fa-paper-plane me-2"></i> Enviar enlace de recuperación
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="<?php echo e(route('login')); ?>" style="color: var(--light-blue);">
                    <i class="fas fa-sign-in-alt me-1"></i> ¿Ya recuerdas tu contraseña? Inicia sesión aquí
                </a>
            </div>

            <hr class="my-3" style="border-top: 1px solid rgba(116, 128, 170, 0.2);">

            <footer class="text-center" style="color: var(--secondary-blue); font-size: 0.9rem;">
                <div class="mb-1">
                    &copy; <script>document.write(new Date().getFullYear())</script> <strong>SIGAT</strong>
                </div>
                <div class="mb-1">
                    Desarrollado por estudiantes de Educación Dual:
                </div>
                <div class="mb-1">
                    <strong>Maico Zaet</strong>, <strong>Mariana Lilibeth</strong>, <strong>Jorge</strong>, <strong>José Ángel</strong>
                </div>
                <div class="mb-1">
                    Carrera: <strong>Ingeniería Informática</strong>
                </div>
                <div>
                    Contacto: <a href="mailto:educaciondualsigat@gmail.com" style="color: var(--light-blue);">educaciondualsigat@gmail.com</a>
                </div>
            </footer>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master-without-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\zaet_\OneDrive\Escritorio\AYUNTAMIENTO\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>