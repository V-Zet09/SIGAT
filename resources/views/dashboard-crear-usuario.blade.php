@extends('layouts.master')
@section('title') Nuevo Usuario @endsection
@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">👤 Crear Usuario</h2>

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre y Sexo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nombre completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="nombre" required value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="sexo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Sexo <span class="text-red-500">*</span>
                    </label>
                    <select name="sexo" id="sexo" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar sexo</option>
                        <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            {{-- ✅ ROL (NUEVO CAMPO) --}}
            <div>
                <label for="rol" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select name="rol" id="rol" required
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="cargo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Cargo <span class="text-red-500">*</span>
                    </label>
                    <select name="cargo" id="cargo" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                    <label for="area" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Área <span class="text-red-500">*</span>
                    </label>
                    <select name="area" id="area" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Contraseña y Confirmar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Contraseña <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10">
                    <i class="bi bi-eye absolute right-3 top-9 cursor-pointer text-gray-500 dark:text-gray-400"
                       onclick="togglePassword('password', this)"></i>
                </div>

                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirmar contraseña <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10">
                    <i class="bi bi-eye absolute right-3 top-9 cursor-pointer text-gray-500 dark:text-gray-400"
                       onclick="togglePassword('password_confirmation', this)"></i>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('usuarios.index') }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
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
</script>
@endsection