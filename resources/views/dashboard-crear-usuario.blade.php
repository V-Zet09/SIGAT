@extends('layouts.master')

@section('title', 'Nuevo Usuario')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
/* Estilos para inputs */
input:focus, select:focus {
  border-color: #16a34a !important;
  ring-width: 2px;
  ring-color: rgba(74, 222, 128, 0.7);
  transition: all 0.3s;
}

input, select {
  transition: all 0.3s;
}

.campo-invalido {
  border-color: #ef4444 !important;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
  20%, 40%, 60%, 80% { transform: translateX(5px); }
}

@media (max-width: 640px) {
  .main-container { 
    padding: 1rem;
    margin: 0.5rem;
    width: calc(100% - 1rem);
  }
}
</style>
@endsection

@section('content')
<div class="shadow-2xl rounded-3xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-8 mx-4 mt-2 animate-fade-in-up">

  <!-- Header visual tipo informes -->
  <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 dark:from-green-700 dark:via-emerald-700 dark:to-teal-700 p-6 shadow-xl">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
    <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div class="flex items-center space-x-4">
        <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
          <i class="fa-solid fa-user-plus text-3xl text-white"></i>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-white">Crear Usuario</h1>
          <p class="text-base text-green-100">Alta de usuario, asignación de rol y permisos institucionales</p>
        </div>
      </div>
      <a href="{{ route('usuarios.index') }}" class="group flex items-center space-x-2 rounded-lg bg-white px-6 py-3 text-base font-semibold text-green-600 shadow-lg transition hover:scale-105">
        <i class="fa-solid fa-users text-lg transition"></i>
        <span>Lista de Usuarios</span>
      </a>
    </div>
  </div>

  <!-- Formulario -->
  <div class="rounded-3xl bg-white dark:bg-gray-800 shadow-2xl p-8 transition-colors duration-300">
    <!-- Alerta de campos vacíos (oculta por defecto) -->
    <div id="alert-campos-vacios" class="hidden bg-red-100 dark:bg-red-900 border-2 border-red-500 dark:border-red-600 text-red-700 dark:text-red-200 px-5 py-4 rounded-lg mb-4 flex items-center gap-3 shadow-xl">
      <i class="fa-solid fa-circle-exclamation text-2xl text-red-600 dark:text-red-400"></i>
      <div>
        <p class="font-bold text-lg">¡Campos obligatorios sin completar!</p>
        <p class="text-sm">Por favor, completa todos los campos marcados con <span class="text-red-600">*</span></p>
      </div>
    </div>

    @if ($errors->any())
      <div class="bg-red-100 dark:bg-red-900 border-2 border-red-500 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-4 flex items-center gap-2 shadow-lg">
        <i class="fa-solid fa-triangle-exclamation text-xl text-red-400 dark:text-yellow-300"></i>
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="form-usuario" action="{{ route('usuarios.store') }}" method="POST" class="space-y-8" novalidate>
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        <div class="md:col-span-2">
          <label for="nombre" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
            Nombre completo <span class="text-red-500">*</span>
          </label>
          <input type="text" name="name" id="nombre" required value="{{ old('name') }}"
            autocomplete="off"
            class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2" />
        </div>
        <div>
          <label for="sexo" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
            Sexo <span class="text-red-500">*</span>
          </label>
          <select name="sexo" id="sexo" required
            class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2">
            <option value="">Seleccionar sexo</option>
            <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
            <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
          </select>
        </div>
      </div>
      <!-- Rol -->
      <div>
        <label for="rol" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
          Rol <span class="text-red-500">*</span>
        </label>
        <select name="rol" id="rol" required
          class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2">
          <option value="">Seleccionar rol</option>
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ old('rol') == $role->name ? 'selected' : '' }}>
              {{ $role->name }}
            </option>
          @endforeach
        </select>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
          El rol determina los permisos y accesos del usuario en el sistema
        </p>
      </div>
      <!-- Cargo y Área -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        <div>
          <label for="cargo" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
            Cargo <span class="text-red-500">*</span>
          </label>
          <select name="cargo" id="cargo" required
            class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2">
            <option value="">Seleccionar cargo</option>
            <option value="Administrador" {{ old('cargo') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
            <option value="Presidente" {{ old('cargo') == 'Presidente' ? 'selected' : '' }}>Presidente municipal</option>
            <option value="Síndico" {{ old('cargo') == 'Síndico' ? 'selected' : '' }}>Síndico procurador</option>
            <option value="Regidor" {{ old('cargo') == 'Regidor' ? 'selected' : '' }}>Regidor</option>
            <option value="Director" {{ old('cargo') == 'Director' ? 'selected' : '' }}>Director de área</option>
            <option value="Auxiliar" {{ old('cargo') == 'Auxiliar' ? 'selected' : '' }}>Auxiliar de área</option>
          </select>
        </div>
        <div>
          <label for="area" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
            Área <span class="text-red-500">*</span>
          </label>
          <select name="area" id="area" required
            class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2">
            <option value="">Seleccionar área</option>
            <option value="Presidencia" {{ old('area') == 'Presidencia' ? 'selected' : '' }}>Presidencia</option>
            <option value="Agua potable" {{ old('area') == 'Agua potable' ? 'selected' : '' }}>Agua potable</option>
            <option value="Informática" {{ old('area') == 'Informática' ? 'selected' : '' }}>Informática</option>
            <option value="Obras públicas" {{ old('area') == 'Obras públicas' ? 'selected' : '' }}>Obras públicas</option>
          </select>
        </div>
      </div>
      <!-- Email -->
      <div>
        <label for="email" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
          Correo electrónico <span class="text-red-500">*</span>
        </label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}"
          autocomplete="off"
          class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2" />
      </div>
      <!-- Contraseña y Confirmar -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="relative">
          <label for="password" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
            Contraseña <span class="text-red-500">*</span>
          </label>
          <input type="password" name="password" id="password" required autocomplete="new-password"
            class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2 pr-10" />
          <i class="bi bi-eye absolute right-3 top-10 cursor-pointer text-gray-500 dark:text-gray-400"
            onclick="togglePassword('password', this)"></i>
        </div>
        <div class="relative">
          <label for="password_confirmation" class="block text-base font-semibold text-gray-800 dark:text-gray-200">
            Confirmar contraseña <span class="text-red-500">*</span>
          </label>
          <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
            class="mt-1 block w-full rounded-lg border-2 border-gray-800 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-100 bg-white text-gray-900 shadow-sm focus:ring-2 focus:ring-green-300 focus:border-green-500 px-3 py-2 pr-10" />
          <i class="bi bi-eye absolute right-3 top-10 cursor-pointer text-gray-500 dark:text-gray-400"
            onclick="togglePassword('password_confirmation', this)"></i>
        </div>
      </div>
      <!-- Botones -->
      <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('usuarios.index') }}"
           class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium text-center">
          Cancelar
        </a>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 transition">
          <i class="fa-solid fa-floppy-disk mr-2"></i>
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
  if (!input) return;
  if (input.type === "password") {
    input.type = "text";
    button.classList.remove("bi-eye");
    button.classList.add("bi-eye-slash");
  } else {
    input.type = "password";
    button.classList.remove("bi-eye-slash");
    button.classList.add("bi-eye");
  }
}
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('form-usuario');
  const alert = document.getElementById('alert-campos-vacios');
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
  form.addEventListener('submit', function(e) {
    const camposRequeridos = form.querySelectorAll('[required]');
    let camposVacios = [];
    camposRequeridos.forEach(campo => campo.classList.remove('campo-invalido'));
    camposRequeridos.forEach(campo => {
      if (!campo.value || campo.value.trim() === '') {
        camposVacios.push(campo);
        campo.classList.add('campo-invalido');
      }
    });
    if (camposVacios.length > 0) {
      e.preventDefault();
      alert.classList.remove('hidden');
      camposVacios[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
      camposVacios[0].focus();
      setTimeout(() => { alert.classList.add('hidden'); }, 5000);
    }
  });
  const inputs = form.querySelectorAll('input, select');
  inputs.forEach(input => {
    input.addEventListener('input', function() {
      this.classList.remove('campo-invalido');
    });
  });
});
</script>
@endsection
