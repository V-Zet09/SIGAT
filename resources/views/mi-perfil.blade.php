@extends('layouts.master')
@section('title', 'Mi Perfil')

@section('content')
<div class="p-6" x-data="profileData()">
    
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Mi Perfil</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Administra tu información personal y seguridad</p>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3" x-data="{ show: true }" x-show="show" x-transition>
            <i class="ri-check-circle-line text-green-600 dark:text-green-400 text-xl"></i>
            <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-green-600 hover:text-green-800">
                <i class="ri-close-line"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-start gap-3">
                <i class="ri-error-warning-line text-red-600 dark:text-red-400 text-xl"></i>
                <div class="flex-1">
                    <p class="font-semibold text-red-800 dark:text-red-200 mb-2">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-red-700 dark:text-red-300 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Card principal --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        
        {{-- Tabs --}}
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px">
                <button @click="activeTab = 'info'" 
                        :class="activeTab === 'info' ? 'border-green-600 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition flex items-center justify-center gap-2">
                    <i class="ri-user-line text-lg"></i>
                    <span>Información Personal</span>
                </button>
                
                <button @click="activeTab = 'security'" 
                        :class="activeTab === 'security' ? 'border-green-600 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition flex items-center justify-center gap-2">
                    <i class="ri-shield-keyhole-line text-lg"></i>
                    <span>Seguridad</span>
                </button>
            </nav>
        </div>

        {{-- Contenido --}}
        <div class="p-6">
            
            {{-- ==================== PESTAÑA 1: INFORMACIÓN PERSONAL ==================== --}}
            <div x-show="activeTab === 'info'" x-transition class="space-y-6">
                
                {{-- Foto de perfil --}}
                <div class="flex flex-col md:flex-row gap-6 items-start pb-6 border-b border-gray-200 dark:border-gray-700">
                    
                    <div class="flex-shrink-0">
                        <div class="relative group">
                            {{-- Preview de la imagen --}}
                            <img :src="avatarPreview" 
                                 alt="Avatar" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700 shadow-lg">
                            
                            {{-- Badge de "Cambios pendientes" --}}
                            <div x-show="avatarChanged || avatarDeleted"
                                 class="absolute -top-2 -right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg animate-pulse">
                                ⚠️ Pendiente
                            </div>
                            
                            {{-- Overlay con opciones --}}
                            <div class="absolute inset-0 bg-black/60 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="flex gap-2">
                                    {{-- Subir desde archivo --}}
                                    <button type="button" 
                                            @click="selectFile()"
                                            class="w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition"
                                            title="Subir foto">
                                        <i class="ri-upload-2-line text-gray-700 text-lg"></i>
                                    </button>
                                    
                                    {{-- Tomar foto con cámara --}}
                                    <button type="button" 
                                            @click="showCameraModal = true"
                                            class="w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition"
                                            title="Tomar foto">
                                        <i class="ri-camera-line text-gray-700 text-lg"></i>
                                    </button>
                                    
                                    {{-- Eliminar foto --}}
                                    @if($user->avatar && $user->avatar !== 'default.jpg')
                                        <button type="button" 
                                                @click="deleteAvatar()"
                                                class="w-10 h-10 bg-red-500/90 hover:bg-red-500 rounded-full flex items-center justify-center transition"
                                                title="Eliminar foto">
                                            <i class="ri-delete-bin-line text-white text-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 text-center">
                            <i class="ri-information-line"></i> Pasa el cursor sobre la foto
                        </p>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $user->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-3">{{ $user->email }}</p>
                        
                        {{-- Rol --}}
                        @if($user->roles->isNotEmpty())
                            @php
                                $rol = $user->roles->first()->name;
                                $colores = [
                                    'Administrador' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                    'Presidente Municipal' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                                    'Síndico Procurador' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                    'Regidor' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                                    'Director de Área' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'Auxiliar de Área' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $colores[$rol] ?? 'bg-gray-100 text-gray-700' }}">
                                <i class="ri-shield-user-line mr-1"></i>
                                {{ $rol }}
                            </span>
                        @endif                        
                        {{-- Información --}}
                        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <p class="text-xs text-blue-800 dark:text-blue-200">
                                <i class="ri-information-line mr-1"></i>
                                <strong>Opciones disponibles:</strong>
                            </p>
                            <ul class="text-xs text-blue-700 dark:text-blue-300 mt-1 space-y-1">
                                <li>📤 Subir desde tu dispositivo (máx. 2MB)</li>
                                <li>📷 Tomar foto con tu cámara</li>
                                @if($user->avatar && $user->avatar !== 'default.jpg')
                                    <li>🗑️ Eliminar y volver a la foto por defecto</li>
                                @endif
                                <li>⚠️ Los cambios se guardan al hacer clic en "Guardar cambios"</li>
                            </ul>
                        </div>
                        
                        {{-- Botón descartar cambios foto --}}
                        <div x-show="avatarChanged || avatarDeleted" 
                             class="mt-4 flex gap-2">
                            <button type="button"
                                    @click="discardChanges()"
                                    class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition flex items-center justify-center gap-2">
                                <i class="ri-close-line"></i>
                                Descartar cambios
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Formulario de información --}}
<form action="{{ route('perfil.update') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      class="space-y-5">
    @csrf
    
    {{-- Input avatar DENTRO del form --}}
    <input type="file" 
           id="avatar-input" 
           name="avatar" 
           accept="image/*" 
           @change="handleFileSelect($event)"
           class="hidden">
    
    {{-- Campo hidden para delete_avatar --}}
    <input type="hidden" 
           name="delete_avatar" 
           :value="avatarDeleted ? '1' : '0'">

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        {{-- Nombre (EDITABLE) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="ri-user-line mr-1"></i>Nombre completo <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 transition"
                   required>
        </div>

        {{-- Email (EDITABLE) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="ri-mail-line mr-1"></i>Correo electrónico <span class="text-red-500">*</span>
            </label>
            <input type="email" 
                   name="email" 
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 transition"
                   required>
        </div>

        {{-- Sexo (SOLO LECTURA) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="ri-user-3-line mr-1"></i>Sexo
                <span class="text-xs text-gray-500 ml-2">(Solo lectura)</span>
            </label>
            <input type="text" 
                   value="{{ $user->sexo ?? 'No especificado' }}"
                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-800 dark:text-gray-300 cursor-not-allowed"
                   disabled
                   readonly>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                <i class="ri-lock-line"></i> Contacta al administrador para cambiar
            </p>
        </div>

        {{-- Cargo (SOLO LECTURA) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="ri-briefcase-line mr-1"></i>Cargo
                <span class="text-xs text-gray-500 ml-2">(Solo lectura)</span>
            </label>
            <input type="text" 
                   value="{{ $user->cargo ?? 'No especificado' }}"
                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-800 dark:text-gray-300 cursor-not-allowed"
                   disabled
                   readonly>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                <i class="ri-lock-line"></i> Contacta al administrador para cambiar
            </p>
        </div>

        {{-- Área (SOLO LECTURA) --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="ri-building-line mr-1"></i>Área
                <span class="text-xs text-gray-500 ml-2">(Solo lectura)</span>
            </label>
            <input type="text" 
                   value="{{ $user->area ?? 'No especificado' }}"
                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-800 dark:text-gray-300 cursor-not-allowed"
                   disabled
                   readonly>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                <i class="ri-lock-line"></i> Contacta al administrador para cambiar
            </p>
        </div>
    </div>

    {{-- Aviso informativo --}}
    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
        <div class="flex items-start gap-3">
            <i class="ri-information-line text-blue-600 dark:text-blue-400 text-xl"></i>
            <div class="flex-1 text-sm text-blue-800 dark:text-blue-200">
                <p class="font-semibold mb-1">Información protegida</p>
                <p>Los campos <strong>Sexo</strong>, <strong>Cargo</strong> y <strong>Área</strong> solo pueden ser modificados por un administrador. Si necesitas actualizar esta información, contacta al departamento de administración.</p>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-4">
        <div class="flex gap-3">
            {{-- Descartar cambios --}}
            <button type="button"
                    @click="discardChanges()"
                    x-show="avatarChanged || avatarDeleted"
                    class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition flex items-center gap-2">
                <i class="ri-close-line"></i>
                Descartar
            </button>
            
            {{-- Guardar cambios --}}
            <button type="submit" 
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="ri-save-line"></i>
                Guardar cambios
            </button>
        </div>
    </div>
</form>

                {{-- Permisos --}}
                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="ri-key-2-line mr-2 text-green-600"></i>Mis Permisos
                    </h3>
                    
                    @if($user->getAllPermissions()->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($user->getAllPermissions() as $permission)
                                <div class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-sm text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    <i class="ri-check-line text-green-600 dark:text-green-400 text-lg"></i>
                                    <span>{{ $permission->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="ri-lock-line text-4xl mb-2"></i>
                            <p class="text-sm">No tienes permisos asignados</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ==================== PESTAÑA 2: SEGURIDAD ==================== --}}
            <div x-show="activeTab === 'security'" x-transition class="space-y-6">
                
                {{-- Advertencia de seguridad --}}
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10 border-l-4 border-yellow-500 p-4 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="ri-information-line text-yellow-600 dark:text-yellow-400 text-xl mt-0.5"></i>
                        <div class="text-sm text-yellow-800 dark:text-yellow-200">
                            <p class="font-semibold mb-2">Consejos de seguridad:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Usa una contraseña con al menos 8 caracteres</li>
                                <li>Combina letras mayúsculas, minúsculas, números y símbolos</li>
                                <li>No uses tu fecha de nacimiento ni palabras comunes</li>
                                <li>Cambia tu contraseña periódicamente</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Cambiar contraseña --}}
                <form action="{{ route('perfil.updatePassword') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="bg-white dark:bg-gray-900/50 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <i class="ri-lock-password-line text-green-600"></i>
                            Cambiar contraseña
                        </h3>
                        
                        {{-- Contraseña actual --}}
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-lock-line mr-1"></i>Contraseña actual
                            </label>
                            <input type="password" name="current_password"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 transition"
                                   placeholder="Ingresa tu contraseña actual"
                                   required>
                        </div>

                        {{-- Nueva contraseña --}}
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-lock-2-line mr-1"></i>Nueva contraseña
                            </label>
                            <input type="password" name="password"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 transition"
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                        </div>

                        {{-- Confirmar contraseña --}}
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ri-lock-2-line mr-1"></i>Confirmar nueva contraseña
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 transition"
                                   placeholder="Repite tu nueva contraseña"
                                   required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i class="ri-key-2-line"></i>
                                Cambiar contraseña
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Historial de sesiones --}}
                <div class="bg-white dark:bg-gray-900/50 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <i class="ri-history-line text-blue-600"></i>
                            Historial de sesiones
                        </h3>
                        <span class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 px-2 py-1 rounded-full">
                            Últimos 10 inicios
                        </span>
                    </div>
                    
                    @if($user->login_history && count($user->login_history) > 0)
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($user->login_history as $index => $login)
                                <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="flex-shrink-0">
                                        @if($index === 0)
                                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                                <i class="ri-check-line text-green-600 dark:text-green-400"></i>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                <i class="ri-computer-line text-gray-600 dark:text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($login['timestamp'])->format('d/m/Y H:i') }}
                                            </p>
                                            @if($index === 0)
                                                <span class="text-xs bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 px-2 py-0.5 rounded-full">
                                                    Sesión actual
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <i class="ri-map-pin-line mr-1"></i>IP: {{ $login['ip'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                            <i class="ri-device-line mr-1"></i>
                                            @php
                                                $agent = $login['user_agent'];
                                                if (str_contains($agent, 'Windows')) echo 'Windows';
                                                elseif (str_contains($agent, 'Mac')) echo 'Mac';
                                                elseif (str_contains($agent, 'Linux')) echo 'Linux';
                                                elseif (str_contains($agent, 'Android')) echo 'Android';
                                                elseif (str_contains($agent, 'iPhone')) echo 'iPhone';
                                                else echo 'Desconocido';
                                                
                                                echo ' - ';
                                                
                                                if (str_contains($agent, 'Chrome')) echo 'Chrome';
                                                elseif (str_contains($agent, 'Firefox')) echo 'Firefox';
                                                elseif (str_contains($agent, 'Safari')) echo 'Safari';
                                                elseif (str_contains($agent, 'Edge')) echo 'Edge';
                                                else echo 'Otro navegador';
                                            @endphp
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Cerrar todas las sesiones --}}
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button @click="showLogoutModal = true" 
                                    class="w-full px-4 py-2.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 font-medium rounded-lg transition flex items-center justify-center gap-2 border border-red-200 dark:border-red-800">
                                <i class="ri-logout-box-line"></i>
                                Cerrar todas las sesiones
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="ri-history-line text-4xl mb-2"></i>
                            <p class="text-sm">No hay historial de sesiones disponible</p>
                            <p class="text-xs mt-1">El historial se generará después de tu próximo inicio de sesión</p>
                        </div>
                    @endif
                </div>

                {{-- Información de la cuenta --}}
                <div class="bg-white dark:bg-gray-900/50 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <i class="ri-information-line text-blue-600"></i>
                        Información de la cuenta
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2">
                                <i class="ri-calendar-line text-gray-500"></i>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Cuenta creada:</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2">
                                <i class="ri-time-line text-gray-500"></i>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Último inicio de sesión:</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'N/A' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2<i class="ri-shield-check-line text-green-500"></i>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Estado de la cuenta:</span>
                            </div>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">
                                ✓ Activa
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Ayuda adicional --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="ri-questionnaire-line text-blue-600 dark:text-blue-400 text-xl"></i>
                        <div class="text-sm text-blue-800 dark:text-blue-200">
                            <p class="font-semibold mb-1">¿Problemas con tu cuenta?</p>
                            <p>Contacta al administrador del sistema o al soporte técnico:</p>
                            <a href="mailto:educaciondualsigat@gmail.com" class="font-medium hover:underline">
                                educaciondualsigat@gmail.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== MODALES ==================== --}}

    {{-- Modal: Cerrar todas las sesiones --}}
    <div x-show="showLogoutModal" 
         x-cloak
         @click.away="showLogoutModal = false"
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div @click.stop class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-logout-box-line text-3xl text-red-600 dark:text-red-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Cerrar todas las sesiones</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Esto cerrará todas las sesiones activas en todos los dispositivos, incluyendo esta sesión actual.
                </p>
            </div>
            
            <form action="{{ route('perfil.logoutAll') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirma tu contraseña:
                    </label>
                    <input type="password" 
                           name="password" 
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"
                           placeholder="Ingresa tu contraseña"
                           required
                           autofocus>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" 
                            @click="showLogoutModal = false"
                            class="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                        <i class="ri-logout-box-line"></i>
                        Cerrar todas
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Tomar foto con cámara --}}
    <div x-show="showCameraModal" 
         x-cloak
         @click.away="showCameraModal = false; stopCamera()"
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div @click.stop class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full p-6 animate-fade-in">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <i class="ri-camera-line text-green-600"></i>
                    Tomar foto
                </h3>
                <button @click="showCameraModal = false; stopCamera()" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            
            {{-- Vista de cámara --}}
            <div class="mb-4">
                <div class="relative bg-gray-900 rounded-lg overflow-hidden" style="height: 400px;">
                    <video id="camera-video" 
                           autoplay 
                           playsinline
                           class="w-full h-full object-cover"
                           style="display: none;"></video>
                    
                    <canvas id="camera-canvas" 
                            class="w-full h-full object-cover"
                            style="display: none;"></canvas>
                    
                    <div id="camera-placeholder" class="absolute inset-0 flex items-center justify-center text-white">
                        <div class="text-center">
                            <i class="ri-camera-off-line text-6xl mb-3 opacity-50"></i>
                            <p class="text-sm opacity-75">Haz clic en "Iniciar cámara" para comenzar</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Botones --}}
            <div class="flex gap-3">
                <button type="button" 
                        @click="startCamera()"
                        id="start-camera-btn"
                        class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="ri-play-line"></i>
                    Iniciar cámara
                </button>
                
                <button type="button" 
                        @click="capturePhoto()"
                        id="capture-btn"
                        style="display: none;"
                        class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="ri-camera-line"></i>
                    Capturar foto
                </button>
                
                <button type="button" 
                        @click="retakePhoto()"
                        id="retake-btn"
                        style="display: none;"
                        class="flex-1 px-4 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="ri-restart-line"></i>
                    Tomar otra
                </button>
                
                <button type="button" 
                        @click="uploadCapturedPhoto()"
                        id="upload-btn"
                        style="display: none;"
                        class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="ri-check-line"></i>
                    Usar esta foto
                </button>
            </div>
        </div>
    </div>

</div>  {{-- ✅ CIERRE DE x-data="profileData()" --}}

{{-- Estilos --}}
<style>
[x-cloak] { display: none !important; }

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

{{-- Scripts --}}
<script>
function profileData() {
    return {
        // Tabs
        activeTab: 'info',
        
        // Modales
        showLogoutModal: false,
        showCameraModal: false,
        
        // Avatar
        avatarPreview: "{{ asset('storage/avatars/' . ($user->avatar ?? 'default.jpg')) }}",
        avatarOriginal: "{{ asset('storage/avatars/' . ($user->avatar ?? 'default.jpg')) }}",
        avatarFile: null,
        avatarChanged: false,
        avatarDeleted: false,
        
        // Cámara
        cameraStream: null,
        capturedImageData: null,
        
        // ==================== MÉTODOS DE AVATAR ====================
        
        selectFile() {
            document.getElementById('avatar-input').click();
        },
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.avatarPreview = e.target.result;
                    this.avatarFile = file;
                    this.avatarChanged = true;
                    this.avatarDeleted = false;
                };
                reader.readAsDataURL(file);
            }
        },
        
        deleteAvatar() {
            this.avatarPreview = "{{ asset('storage/avatars/default.jpg') }}";
            this.avatarDeleted = true;
            this.avatarChanged = false;
            this.avatarFile = null;
            document.getElementById('avatar-input').value = '';
        },

        discardChanges() {
            this.avatarPreview = this.avatarOriginal;
            this.avatarChanged = false;
            this.avatarDeleted = false;
            this.avatarFile = null;
            document.getElementById('avatar-input').value = '';
        },
        
        // ==================== MÉTODOS DE CÁMARA ====================
        
        startCamera() {
            const video = document.getElementById('camera-video');
            const placeholder = document.getElementById('camera-placeholder');
            const startBtn = document.getElementById('start-camera-btn');
            const captureBtn = document.getElementById('capture-btn');
            
            navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'user'
                } 
            })
            .then(stream => {
                this.cameraStream = stream;
                video.srcObject = stream;
                video.style.display = 'block';
                placeholder.style.display = 'none';
                startBtn.style.display = 'none';
                captureBtn.style.display = 'flex';
            })
            .catch(err => {
                alert('No se pudo acceder a la cámara: ' + err.message);
                console.error('Error accessing camera:', err);
            });
        },
        
        stopCamera() {
            if (this.cameraStream) {
                this.cameraStream.getTracks().forEach(track => track.stop());
                this.cameraStream = null;
            }
            
            const video = document.getElementById('camera-video');
            const canvas = document.getElementById('camera-canvas');
            const placeholder = document.getElementById('camera-placeholder');
            const startBtn = document.getElementById('start-camera-btn');
            const captureBtn = document.getElementById('capture-btn');
            const retakeBtn = document.getElementById('retake-btn');
            const uploadBtn = document.getElementById('upload-btn');
            
            if (video) video.style.display = 'none';
            if (canvas) canvas.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
            if (startBtn) startBtn.style.display = 'flex';
            if (captureBtn) captureBtn.style.display = 'none';
            if (retakeBtn) retakeBtn.style.display = 'none';
            if (uploadBtn) uploadBtn.style.display = 'none';
            
            this.capturedImageData = null;
        },
        
        capturePhoto() {
            const video = document.getElementById('camera-video');
            const canvas = document.getElementById('camera-canvas');
            const captureBtn = document.getElementById('capture-btn');
            const retakeBtn = document.getElementById('retake-btn');
            const uploadBtn = document.getElementById('upload-btn');
            
            if (!video || !canvas) {
                console.error('Video or canvas element not found');
                return;
            }
            
            // Configurar canvas
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Capturar imagen
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);
            
            // Guardar imagen como data URL
            this.capturedImageData = canvas.toDataURL('image/jpeg', 0.9);
            
            // Detener el stream de la cámara
            if (this.cameraStream) {
                this.cameraStream.getTracks().forEach(track => track.stop());
                this.cameraStream = null;
            }
            
            // Actualizar UI
            video.style.display = 'none';
            canvas.style.display = 'block';
            if (captureBtn) captureBtn.style.display = 'none';
            if (retakeBtn) retakeBtn.style.display = 'flex';
            if (uploadBtn) uploadBtn.style.display = 'flex';
        },
        
        retakePhoto() {
            const canvas = document.getElementById('camera-canvas');
            const retakeBtn = document.getElementById('retake-btn');
            const uploadBtn = document.getElementById('upload-btn');
            
            if (canvas) canvas.style.display = 'none';
            if (retakeBtn) retakeBtn.style.display = 'none';
            if (uploadBtn) uploadBtn.style.display = 'none';
            
            this.capturedImageData = null;
            this.startCamera();
        },
        
        uploadCapturedPhoto() {
            if (!this.capturedImageData) return;
            
            fetch(this.capturedImageData)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], 'camera-photo.jpg', { type: 'image/jpeg' });
                    
                    // Actualizar preview y marcar como cambiado
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.avatarPreview = e.target.result;
                        this.avatarFile = file;
                        this.avatarChanged = true;
                        this.avatarDeleted = false;
                    };
                    reader.readAsDataURL(file);
                    
                    // Cerrar modal
                    this.showCameraModal = false;
                    this.stopCamera();
                })
                .catch(err => {
                    console.error('Error al procesar la foto:', err);
                    alert('Error al procesar la foto');
                });
        }
    }
}
</script>
@endsection