@extends('layouts.master')

@section('title', 'Perfil de Usuario')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header con botón volver --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-green-500 rounded-lg">
                        <i class="ri-user-line text-white text-2xl"></i>
                    </div>
                    Perfil de Usuario
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Información detallada del usuario</p>
            </div>
            <a href="{{ route('usuarios.index') }}"
               class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition flex items-center gap-2 shadow-md">
                <i class="ri-arrow-left-line"></i>
                Volver
            </a>
        </div>

        {{-- Tarjeta principal con foto de perfil --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            
            {{-- Header con gradiente --}}
            <div class="relative h-40 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500">
                <div class="absolute inset-0 bg-black/10"></div>
                
                {{-- Badge de estado en línea --}}
                <div class="absolute top-4 right-4">
                    @if(isUserOnline($usuario->id))
                        <span class="flex items-center gap-2 text-sm bg-white/95 text-green-700 px-4 py-2 rounded-full font-semibold shadow-lg">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                            En línea
                        </span>
                    @else
                        <span class="flex items-center gap-2 text-sm bg-white/95 text-gray-600 px-4 py-2 rounded-full font-semibold shadow-lg">
                            <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                            Desconectado
                        </span>
                    @endif
                </div>
            </div>

            {{-- Foto de perfil centrada --}}
            <div class="relative -mt-20 flex justify-center px-6">
                <div class="relative">
                    @if($usuario->avatar && file_exists(public_path('storage/avatars/'.$usuario->avatar)))
                        <img src="{{ asset('storage/avatars/'.$usuario->avatar) }}" 
                             alt="{{ $usuario->name }}"
                             class="w-40 h-40 rounded-2xl object-cover border-8 border-white dark:border-gray-800 shadow-2xl">
                    @else
                        {{-- Avatar con iniciales --}}
                        <div class="w-40 h-40 rounded-2xl flex items-center justify-center text-5xl font-bold text-white bg-gradient-to-br from-green-500 to-emerald-600 border-8 border-white dark:border-gray-800 shadow-2xl">
                            {{ strtoupper(substr($usuario->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    {{-- Badge de estado en la foto --}}
                    @if(isUserOnline($usuario->id))
                        <span class="absolute bottom-2 right-2 block h-8 w-8 rounded-full bg-green-500 ring-4 ring-white dark:ring-gray-800 shadow-lg"></span>
                    @else
                        <span class="absolute bottom-2 right-2 block h-8 w-8 rounded-full bg-gray-400 ring-4 ring-white dark:ring-gray-800 shadow-lg"></span>
                    @endif
                </div>
            </div>

            {{-- Información del usuario --}}
            <div class="px-8 pb-8">
                
                {{-- Nombre y rol --}}
                <div class="mt-6 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $usuario->name }}
                    </h2>
                    <p class="mt-2 text-lg text-gray-500 dark:text-gray-400">
                        {{ $usuario->cargo ?? 'Sin cargo asignado' }}
                    </p>
                    
                    {{-- Badge de rol --}}
                    <div class="mt-4 flex justify-center">
                        @if($usuario->roles->isNotEmpty())
                            @php
                                $rol = $usuario->roles->first()->name;
                                $colores = [
                                    'Administrador'          => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 border-red-300',
                                    'Presidente Municipal'   => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300 border-purple-300',
                                    'Síndico Procurador'     => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border-blue-300',
                                    'Regidor'                => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 border-green-300',
                                    'Director de Área'       => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 border-yellow-300',
                                    'Auxiliar de Área'       => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border-gray-300',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border-2 {{ $colores[$rol] ?? 'bg-gray-100 text-gray-700 border-gray-300' }} shadow-sm">
                                <i class="ri-shield-star-line text-lg"></i>
                                {{ $rol }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Divisor --}}
                <div class="my-8 border-t border-gray-200 dark:border-gray-700"></div>

                {{-- Grid de información --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Sexo --}}
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <i class="ri-user-3-line text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sexo</p>
                        </div>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white ml-11">
                            {{ $usuario->sexo ?? 'No especificado' }}
                        </p>
                    </div>

                    {{-- Área --}}
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <i class="ri-building-line text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Área</p>
                        </div>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white ml-11">
                            {{ $usuario->area ?? 'Sin área asignada' }}
                        </p>
                    </div>

                    {{-- Email --}}
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 border border-gray-200 dark:border-gray-600 md:col-span-2">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <i class="ri-mail-line text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Correo Electrónico</p>
                        </div>
                        <a href="mailto:{{ $usuario->email }}" 
                           class="text-lg font-semibold text-green-600 dark:text-green-400 hover:underline ml-11">
                            {{ $usuario->email }}
                        </a>
                    </div>

                    {{-- Última actividad --}}
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 border border-gray-200 dark:border-gray-600 md:col-span-2">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                                <i class="ri-time-line text-orange-600 dark:text-orange-400 text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Última Actividad</p>
                        </div>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white ml-11">
                            @if($usuario->last_activity_at)
                                {{ $usuario->last_activity_at->diffForHumans() }}
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    ({{ $usuario->last_activity_at->format('d/m/Y H:i') }})
                                </span>
                            @else
                                <span class="text-gray-400 dark:text-gray-500">Sin actividad registrada</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="mt-8 flex flex-wrap gap-3 justify-center">
                    <a href="{{ route('vista-editar-usuario', $usuario->id) }}"
                       class="flex items-center gap-2 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-semibold transition shadow-lg hover:shadow-xl">
                        <i class="ri-edit-line"></i>
                        Editar Usuario
                    </a>
                    
                    <a href="mailto:{{ $usuario->email }}"
                       class="flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition shadow-lg hover:shadow-xl">
                        <i class="ri-mail-send-line"></i>
                        Enviar Correo
                    </a>
                    
                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition shadow-lg hover:shadow-xl">
                            <i class="ri-delete-bin-line"></i>
                            Eliminar Usuario
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sección de permisos (si tiene) --}}
        @if($usuario->roles->isNotEmpty() || $usuario->permissions->isNotEmpty())
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <i class="ri-shield-check-line text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                Roles y Permisos
            </h3>
            
            {{-- Roles --}}
            @if($usuario->roles->isNotEmpty())
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Roles Asignados</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($usuario->roles as $rol)
                        <span class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-semibold border border-blue-300 dark:border-blue-700">
                            {{ $rol->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
            
            {{-- Permisos --}}
            @if($usuario->permissions->isNotEmpty())
            <div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Permisos Directos</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($usuario->permissions as $permiso)
                        <span class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg text-sm font-medium border border-green-300 dark:border-green-700">
                            {{ $permiso->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection
