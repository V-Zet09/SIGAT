@extends('layouts.master')
@section('title', 'Usuarios')

@section('css')
<style>
[x-cloak] { display: none !important; }
</style>
@endsection

@section('content')
<div class="shadow-2xl rounded-3xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-8 mx-4 my-4">
  <!-- Header visual tipo informes -->
  <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 dark:from-green-700 dark:via-emerald-700 dark:to-teal-700 p-6 shadow-xl">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
    <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div class="flex items-center space-x-4">
        <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
          <i class="ri-user-line text-3xl text-white"></i>
        </div>
        <div>
          <h1 class="text-3xl font-bold text-white">Registro General de Usuarios</h1>
          <p class="text-base text-green-100">Usuarios registrados en el sistema</p>
        </div>
      </div>
      <a href="{{ route('dashboard-crear-usuario') }}" class="group flex items-center space-x-2 rounded-lg bg-white px-6 py-3 text-base font-semibold text-green-600 shadow-lg transition hover:scale-105">
        <i class="ri-add-line text-lg transition"></i>
        <span>Agregar Usuario</span>
      </a>
    </div>
  </div>

  {{-- Mensajes --}}
  @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg flex items-center gap-3">
      <i class="ri-check-line text-green-600 dark:text-green-400 text-xl"></i>
      <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg flex items-center gap-3">
      <i class="ri-error-warning-line text-red-600 dark:text-red-400 text-xl"></i>
      <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
    </div>
  @endif

  {{-- Card contenedor --}}
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    {{-- Toolbar --}}
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        {{-- Búsqueda --}}
        <div class="relative flex-1 max-w-md">
          <form method="GET" action="{{ route('usuarios.index') }}" class="relative flex-1 max-w-md">
            <input type="text" name="search"
              value="{{ request('search') }}"
              placeholder="Buscar por nombre, email, cargo..."
              class="w-full pl-10 pr-4 py-2 border-2 border-gray-800 dark:border-gray-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          </form>
        </div>
        {{-- Botones --}}
        <div class="flex items-center gap-2">
          <button class="px-4 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition flex items-center gap-2">
            <i class="ri-delete-bin-line"></i>
            <span class="hidden sm:inline">Eliminar</span>
          </button>
          <a href="{{ route('usuarios.index') }}"
            class="px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition flex items-center gap-2">
            <i class="ri-filter-3-line"></i>
            <span class="hidden sm:inline">Limpiar</span>
          </a>
        </div>
      </div>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-green-600 text-white">
          <tr>
            <th class="px-4 py-3 text-left w-12">
              <input type="checkbox" class="w-4 h-4 rounded border-white/30 bg-white/10 focus:ring-2 focus:ring-white/50">
            </th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Sexo</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Rol</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Área</th>
            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Correo</th>
            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          @forelse ($usuarios as $usuario)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
              <td class="px-4 py-4">
                <input type="checkbox" value="{{ $usuario->id }}" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-green-600 focus:ring-2 focus:ring-green-500">
              </td>
              <td class="px-4 py-4 font-medium text-gray-900 dark:text-gray-100">
                {{ $usuario->name }}
              </td>
              <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                {{ $usuario->sexo ?? 'N/A' }}
              </td>
              <td class="px-4 py-4">
                @if($usuario->roles->isNotEmpty())
                  @php
                    $rol = $usuario->roles->first()->name;
                    $colores = [
                      'Administrador' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                      'Presidente Municipal' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                      'Síndico Procurador' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                      'Regidor' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                      'Director de Área' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                      'Auxiliar de Área' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                    ];
                  @endphp
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $colores[$rol] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $rol }}
                  </span>
                @else
                  <span class="text-gray-400 dark:text-gray-500 text-xs italic">Sin rol</span>
                @endif
              </td>

              <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                {{ $usuario->area ?? 'N/A' }}
              </td>
              <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                {{ $usuario->email }}
              </td>
              <!-- ACCIONES: DROPDOWN MODERNO Y SIEMPRE VISIBLE -->
              <td class="px-4 py-4">
                <div class="flex justify-center">
                  <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                      x-ref="button{{ $usuario->id }}"
                      class="px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2 text-sm font-medium">
                      <span>Opciones</span>
                      <i class="ri-arrow-down-s-line" :class="open && 'rotate-180'" class="transition-transform"></i>
                    </button>
                    <template x-teleport="body">
                      <div x-show="open"
                        x-cloak
                        @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        x-init="$watch('open', value => {
                          if (value) {
                            $nextTick(() => {
                              const button = $refs.button{{ $usuario->id }}.getBoundingClientRect();
                              $el.style.top = (button.bottom + window.scrollY + 8) + 'px';
                              $el.style.left = (button.right + window.scrollX - 160) + 'px';
                            });
                          }
                        })"
                        style="position: absolute; width: 10rem;"
                        class="z-[9999] rounded-lg bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-1">
                        <a href="{{ route('usuarios.show', $usuario->id) }}"
                          class="flex items-center gap-2 px-4 py-2 text-sm text-green-600 dark:text-green-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                          <i class="ri-eye-line"></i>
                          <span>Ver</span>
                        </a>
                        <a href="{{ route('vista-editar-usuario', $usuario->id) }}"
                          class="flex items-center gap-2 px-4 py-2 text-sm text-yellow-600 dark:text-yellow-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                          <i class="ri-edit-line"></i>
                          <span>Editar</span>
                        </a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                          onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-left">
                            <i class="ri-delete-bin-line"></i>
                            <span>Eliminar</span>
                          </button>
                        </form>
                      </div>
                    </template>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-4 py-12 text-center">
                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                  <i class="ri-user-line text-5xl mb-3"></i>
                  <p class="font-medium">No hay usuarios registrados</p>
                  <p class="text-sm mt-1">Comienza agregando un nuevo usuario</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
