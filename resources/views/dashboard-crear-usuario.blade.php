@extends('layouts.master')

@section('title', 'Nuevo Usuario')

@section('css')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    // Configurar Tailwind para usar clase manual en lugar de media query
    tailwind.config = {
        darkMode: 'class',
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>
@endsection

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-6 sm:p-8 animate-fade-in-up">
        
        <!-- Header del formulario -->
        <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 shadow-lg">
                    <i class="fas fa-user-plus text-2xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Crear Usuario</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete el formulario para registrar un nuevo usuario</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre y Sexo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user text-blue-500 dark:text-blue-400 mr-2"></i>
                        Nombre completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="nombre" 
                           required
                           placeholder="Ingrese el nombre completo"
                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition">
                </div>

                <div>
                    <label for="sexo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-venus-mars text-purple-500 dark:text-purple-400 mr-2"></i>
                        Sexo <span class="text-red-500">*</span>
                    </label>
                    <select name="sexo" 
                            id="sexo" 
                            required
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition">
                        <option value="" class="dark:bg-gray-700">Seleccionar sexo</option>
                        <option value="Femenino" class="dark:bg-gray-700">Femenino</option>
                        <option value="Masculino" class="dark:bg-gray-700">Masculino</option>
                        <option value="Otro" class="dark:bg-gray-700">Otro</option>
                    </select>
                </div>
            </div>

            <!-- Cargo y Área -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label for="cargo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-briefcase text-green-500 dark:text-green-400 mr-2"></i>
                        Cargo <span class="text-red-500">*</span>
                    </label>
                    <select name="cargo" 
                            id="cargo" 
                            required
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition">
                        <option value="" class="dark:bg-gray-700">Seleccionar cargo</option>
                        <option value="Administrador" class="dark:bg-gray-700">Administrador</option>
                        <option value="Presidente" class="dark:bg-gray-700">Presidente municipal</option>
                        <option value="Síndico" class="dark:bg-gray-700">Síndico procurador</option>
                        <option value="Regidor" class="dark:bg-gray-700">Regidor</option>
                        <option value="Director" class="dark:bg-gray-700">Director de área</option>
                        <option value="Auxiliar" class="dark:bg-gray-700">Auxiliar de área</option>
                    </select>
                </div>

                <div>
                    <label for="area" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-building text-orange-500 dark:text-orange-400 mr-2"></i>
                        Área <span class="text-red-500">*</span>
                    </label>
                    <select name="area" 
                            id="area" 
                            required
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition">
                        <option value="" class="dark:bg-gray-700">Seleccionar área</option>
                        <option value="Presidencia" class="dark:bg-gray-700">Presidencia</option>
                        <option value="Agua potable" class="dark:bg-gray-700">Agua potable</option>
                        <option value="Informática" class="dark:bg-gray-700">Informática</option>
                        <option value="Obras públicas" class="dark:bg-gray-700">Obras públicas</option>
                    </select>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-envelope text-red-500 dark:text-red-400 mr-2"></i>
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       required
                       placeholder="ejemplo@correo.com"
                       class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition">
            </div>

            <!-- Contraseña y Confirmar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock text-indigo-500 dark:text-indigo-400 mr-2"></i>
                        Contraseña <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required
                               placeholder="Mínimo 8 caracteres"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-3 pr-12 transition">
                        <button type="button"
                                onclick="togglePassword('password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition">
                            <i class="bi bi-eye text-xl"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-check-circle text-teal-500 dark:text-teal-400 mr-2"></i>
                        Confirmar contraseña <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               required
                               placeholder="Repita la contraseña"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-3 pr-12 transition">
                        <button type="button"
                                onclick="togglePassword('password_confirmation', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition">
                            <i class="bi bi-eye text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Nota informativa -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 dark:border-blue-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 dark:text-blue-400 text-xl mt-0.5 mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Información importante</p>
                        <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Los campos marcados con <span class="text-red-500">*</span> son obligatorios. La contraseña debe tener al menos 8 caracteres.</p>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('usuarios.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition shadow-md">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}

// Validación en tiempo real de contraseñas
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    
    if (password && passwordConfirm) {
        passwordConfirm.addEventListener('input', function() {
            if (password.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Las contraseñas no coinciden');
            } else {
                passwordConfirm.setCustomValidity('');
            }
        });
        
        password.addEventListener('input', function() {
            if (passwordConfirm.value && password.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Las contraseñas no coinciden');
            } else {
                passwordConfirm.setCustomValidity('');
            }
        });
    }
});
</script>
@endsection