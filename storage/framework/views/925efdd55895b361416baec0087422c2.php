

<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('translation.signin'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid vh-100">
  <div class="row h-100">
    <!-- Columna de la imagen (solo visible en pantallas medianas y grandes) -->
    <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center bg-light">
      <div class="text-center p-5">
        <img src="<?php echo e(asset('images/logo-login.jpeg')); ?>" 
             alt="Logo SIGAT" 
             class="img-fluid shadow-lg rounded-4 mb-4"
             style="width: 600px; height: 600px; object-fit: contain;">
      </div>
    </div>
        <!-- Login derecho perfectamente alineado -->
        <div class="col-md-6 d-flex justify-content-center align-items-center bg-light">
            <div class="w-100 px-4" style="max-width: 400px;">
                <div class="card border-0 shadow-lg rounded-4 h-100 d-flex justify-content-center">
                    <div class="card-body p-4 fs-6">
                        <div class="text-center mb-4">
                            <h5 class="text-primary fs-4">Bienvenido</h5>
                            <p class="text-muted">Inicia sesión para acceder a SIGAT</p>
                        </div>

                        <form action="<?php echo e(route('login')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control fs-6 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="username" name="email" value="<?php echo e(old('email')); ?>" placeholder="Ingresa tu usuario">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="password-input" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                    <a href="<?php echo e(route('password.update')); ?>" class="text-muted small">¿Olvidaste la contraseña?</a>
                                </div>
                                <div class="position-relative">
                                    <input type="password" class="form-control fs-6 pe-5 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" id="password-input" placeholder="Ingresa tu contraseña">
                                    <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-2 p-0" id="toggle-password">
                                        <i class="ri-eye-fill align-middle" id="toggle-icon"></i>
                                    </button>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="auth-remember-check">
                                <label class="form-check-label" for="auth-remember-check">Recuérdame</label>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-success" type="submit">Iniciar sesión</button>
                            </div>

                            
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="mt-4">
                    <div class="text-center p-3 border-top border-2 rounded bg-white shadow-sm">
                        <p class="mb-0 text-muted small">
                            &copy; <script>document.write(new Date().getFullYear())</script> <strong>SIGAT</strong><br>
                            Desarrollado por Estudiantes de Educación Dual:<br>
                            <strong>Maico Zaet</strong>, <strong>Mariana Lilibeth</strong>, <strong>Jorge</strong>, <strong>José Ángel</strong><br>
                            Carrera: <strong>Ingeniería Informática</strong><br>
                            Contacto: <a href="mailto:educaciondualsigat@gmail.com">educaciondualsigat@gmail.com</a>
                        </p>
                    </div>
                </footer>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/particles.js/particles.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/particles.app.js')); ?>"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggle-password");
        const passwordInput = document.getElementById("password-input");
        const icon = document.getElementById("toggle-icon");

        toggleBtn.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("ri-eye-fill");
                icon.classList.add("ri-eye-off-fill");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("ri-eye-off-fill");
                icon.classList.add("ri-eye-fill");
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\zaet_\OneDrive\Escritorio\AYUNTAMIENTO\resources\views/auth/login.blade.php ENDPATH**/ ?>