@extends('layouts.master')
@section('title', 'Editar Usuario')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Usuarios @endslot
    @slot('title') Editar usuario @endslot
@endcomponent

<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">✏️ Editar Usuario</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $usuario->id }}</span>
        </div>

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

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre y Sexo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nombre completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required 
                        value="{{ old('name', $usuario->name) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="sexo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Sexo <span class="text-red-500">*</span>
                    </label>
                    <select name="sexo" id="sexo" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar sexo</option>
                        <option value="Femenino" {{ old('sexo', $usuario->sexo) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Masculino" {{ old('sexo', $usuario->sexo) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Otro" {{ old('sexo', $usuario->sexo) == 'Otro' ? 'selected' : '' }}>Otro</option>
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
                        <option value="{{ $role->name }}" 
                            {{ old('rol', $usuario->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                
                {{-- Mostrar rol actual --}}
                @if($usuario->roles->isNotEmpty())
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Rol actual: 
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($usuario->hasRole('Administrador')) bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @elseif($usuario->hasRole('Presidente Municipal')) bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                            @elseif($usuario->hasRole('Síndico Procurador')) bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($usuario->hasRole('Regidor')) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($usuario->hasRole('Director de Área')) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($usuario->hasRole('Auxiliar de Área')) bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @endif">
                            {{ $usuario->roles->first()->name }}
                        </span>
                    </p>
                @endif
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
                        <option value="Administrador" {{ old('cargo', $usuario->cargo) == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Presidente" {{ old('cargo', $usuario->cargo) == 'Presidente' ? 'selected' : '' }}>Presidente municipal</option>
                        <option value="Síndico" {{ old('cargo', $usuario->cargo) == 'Síndico' ? 'selected' : '' }}>Síndico procurador</option>
                        <option value="Regidor" {{ old('cargo', $usuario->cargo) == 'Regidor' ? 'selected' : '' }}>Regidor</option>
                        <option value="Director" {{ old('cargo', $usuario->cargo) == 'Director' ? 'selected' : '' }}>Director de área</option>
                        <option value="Auxiliar" {{ old('cargo', $usuario->cargo) == 'Auxiliar' ? 'selected' : '' }}>Auxiliar de área</option>
                    </select>
                </div>

                <div>
    <label for="area" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Área <span class="text-red-500">*</span>
    </label>
    <select name="area" id="area" required
        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">Seleccionar área</option>
        <option value="Agua potable" {{ old('area', $usuario->area) == 'Agua potable' ? 'selected' : '' }}>Agua potable</option>
        <option value="Bienestar Social y Desarrollo Rural" {{ old('area', $usuario->area) == 'Bienestar Social y Desarrollo Rural' ? 'selected' : '' }}>Bienestar Social y Desarrollo Rural</option>
        <option value="Catastro" {{ old('area', $usuario->area) == 'Catastro' ? 'selected' : '' }}>Catastro</option>
        <option value="Contraloria Interna" {{ old('area', $usuario->area) == 'Contraloria Interna' ? 'selected' : '' }}>Contraloria Interna</option>
        <option value="Deportes" {{ old('area', $usuario->area) == 'Deportes' ? 'selected' : '' }}>Deportes</option>
        <option value="DIF" {{ old('area', $usuario->area) == 'DIF' ? 'selected' : '' }}>DIF</option>
        <option value="Informática" {{ old('area', $usuario->area) == 'Informática' ? 'selected' : '' }}>Informática</option>
        <option value="Limpia" {{ old('area', $usuario->area) == 'Limpia' ? 'selected' : '' }}>Limpia</option>
        <option value="Obras Publicas" {{ old('area', $usuario->area) == 'Obras Publicas' ? 'selected' : '' }}>Obras Publicas</option>
        <option value="Oficialia Mayor" {{ old('area', $usuario->area) == 'Oficialia Mayor' ? 'selected' : '' }}>Oficialia Mayor</option>
        <option value="Presidencia" {{ old('area', $usuario->area) == 'Presidencia' ? 'selected' : '' }}>Presidencia</option>
        <option value="Recursos Humanos" {{ old('area', $usuario->area) == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos</option>
        <option value="Registro Civil" {{ old('area', $usuario->area) == 'Registro Civil' ? 'selected' : '' }}>Registro Civil</option>
        <option value="Regidores" {{ old('area', $usuario->area) == 'Regidores' ? 'selected' : '' }}>Regidores</option>
        <option value="Reglamentos" {{ old('area', $usuario->area) == 'Reglamentos' ? 'selected' : '' }}>Reglamentos</option>
        <option value="Secretaria General" {{ old('area', $usuario->area) == 'Secretaria General' ? 'selected' : '' }}>Secretaria General</option>
        <option value="Seguridad Publica" {{ old('area', $usuario->area) == 'Seguridad Publica' ? 'selected' : '' }}>Seguridad Publica</option>
        <option value="Sindicatura" {{ old('area', $usuario->area) == 'Sindicatura' ? 'selected' : '' }}>Sindicatura</option>
        <option value="Tesoreria" {{ old('area', $usuario->area) == 'Tesoreria' ? 'selected' : '' }}>Tesoreria</option>
        <option value="Transito" {{ old('area', $usuario->area) == 'Transito' ? 'selected' : '' }}>Transito</option>
    </select>
</div>

            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" required 
                    value="{{ old('email', $usuario->email) }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    El correo se usa para iniciar sesión
                </p>
            </div>

            {{-- Información adicional --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Nota:</strong> No es necesario cambiar la contraseña. Solo se modificará si es necesario desde la vista de perfil del usuario.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                <a href="{{ route('usuarios.index') }}"
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection