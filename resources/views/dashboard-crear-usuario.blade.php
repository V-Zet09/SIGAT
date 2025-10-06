@extends('layouts.master')
@section('title') Nuevo Usuario @endsection
@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="bg-white shadow-xl rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">👤 Crear Usuario</h2>

        <!-- Formulario -->
        <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre y Sexo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre completo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="nombre" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo <span class="text-red-500">*</span></label>
                    <select name="sexo" id="sexo" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar sexo</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>

            <!-- Cargo y Área -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="cargo" class="block text-sm font-medium text-gray-700">Cargo <span class="text-red-500">*</span></label>
                    <select name="cargo" id="cargo" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar cargo</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Presidente">Presidente municipal</option>
                        <option value="Síndico">Síndico procurador</option>
                        <option value="Regidor">Regidor</option>
                        <option value="Director">Director de área</option>
                        <option value="Auxiliar">Auxiliar de área</option>
                    </select>
                </div>

                <div>
                    <label for="area" class="block text-sm font-medium text-gray-700">Área <span class="text-red-500">*</span></label>
                    <select name="area" id="area" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar área</option>
                        <option value="Presidencia">Presidencia</option>
                        <option value="Agua potable">Agua potable</option>
                        <option value="Informática">Informática</option>
                        <option value="Obras públicas">Obras públicas</option>
                    </select>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Contraseña y Confirmar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10">
                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
                       onclick="togglePassword('password', this)"></i>
                </div>

                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10">
                    <i class="bi bi-eye absolute right-3 top-9 cursor-pointer text-gray-500"
                       onclick="togglePassword('password_confirmation', this)"></i>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('usuarios.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Guardar
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
