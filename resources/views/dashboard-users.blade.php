@extends('layouts.master')
@section('title', 'Usuarios')

@section('css')
<style>
[x-cloak] { display: none !important; }
</style>
@endsection

@section('content')
<div class="shadow-2xl rounded-3xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4 sm:p-8 mx-4 mt-0">

  <!-- Header compacto -->
  <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 dark:from-green-700 dark:via-emerald-700 dark:to-teal-700 p-4 sm:p-6 shadow-xl">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
      <div class="flex items-center space-x-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
          <i class="ri-user-line text-2xl text-white"></i>
        </div>
        <div>
          <h1 class="text-xl sm:text-2xl font-bold text-white">Usuarios del Sistema</h1>
          <p class="text-sm text-green-100">{{ $usuarios->total() }} registrados</p>
        </div>
      </div>
      <a href="{{ route('dashboard-crear-usuario') }}" class="flex items-center space-x-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-green-600 shadow-lg transition hover:scale-105">
        <i class="ri-add-line"></i>
        <span>Agregar</span>
      </a>
    </div>
  </div>

  {{-- Mensajes --}}
  @if(session('success'))
    <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg flex items-center gap-2 text-sm">
      <i class="ri-check-line text-green-600 dark:text-green-400"></i>
      <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg flex items-center gap-2 text-sm">
      <i class="ri-error-warning-line text-red-600 dark:text-red-400"></i>
      <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
    </div>
  @endif

  {{-- Card contenedor --}}
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">

    {{-- Toolbar compacto --}}
    <div class="p-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
      <div class="flex flex-col sm:flex-row gap-2">
        <form method="GET" action="{{ route('usuarios.index') }}" class="flex flex-1 gap-2">
          {{-- Búsqueda --}}
          <div class="relative flex-1">
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Buscar..."
                   class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          </div>

          {{-- Filtro estado --}}
          <select name="estado"
                  class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500"
                  onchange="this.form.submit()">
            <option value="">Todos</option>
            <option value="conectado" {{ request('estado') === 'conectado' ? 'selected' : '' }}>🟢 Online</option>
            <option value="desconectado" {{ request('estado') === 'desconectado' ? 'selected' : '' }}>⚫ Offline</option>
          </select>

          <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
            <i class="ri-search-2-line"></i>
          </button>
        </form>

        <a href="{{ route('usuarios.index') }}"
           class="px-3 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 text-sm flex items-center justify-center gap-1">
          <i class="ri-filter-off-line"></i>
          <span class="hidden sm:inline">Limpiar</span>
        </a>
      </div>
    </div>

    {{-- Tabla compacta --}}
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gradient-to-r from-green-600 to-emerald-600 text-white">
          <tr>
            <th class="px-3 py-3 text-left text-xs font-bold uppercase">Usuario</th>
            <th class="px-3 py-3 text-left text-xs font-bold uppercase">Rol</th>
            <th class="px-3 py-3 text-left text-xs font-bold uppercase">Correo</th>
            <th class="px-3 py-3 text-center text-xs font-bold uppercase">Estado</th>
            <th class="px-3 py-3 text-center text-xs font-bold uppercase">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          @forelse ($usuarios as $usuario)
            <tr class="hover:bg-green-50 dark:hover:bg-gray-700/50 transition">
              
              {{-- Usuario con avatar más grande --}}
              <td class="px-3 py-3">
                <div class="flex items-center gap-2">
                  <div class="relative flex-shrink-0">
                    @if($usuario->avatar && file_exists(public_path('storage/avatars/'.$usuario->avatar)))
                      <img src="{{ asset('storage/avatars/'.$usuario->avatar) }}" 
                           alt="{{ $usuario->name }}"
                           class="w-10 h-10 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-600">
                    @else
                      {{-- Inicial MÁS GRANDE y visible --}}
                      <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg font-bold text-white bg-gradient-to-br from-green-500 to-emerald-600 border-2 border-gray-200 dark:border-gray-600 shadow-sm">
                        {{ strtoupper(substr($usuario->name, 0, 1)) }}
                      </div>
                    @endif
                    
                    {{-- Badge estado --}}
                    @if(isUserOnline($usuario->id))
                      <span class="absolute -bottom-0.5 -right-0.5 block h-3 w-3 rounded-full bg-green-500 ring-2 ring-white dark:ring-gray-800"></span>
                    @else
                      <span class="absolute -bottom-0.5 -right-0.5 block h-3 w-3 rounded-full bg-gray-400 ring-2 ring-white dark:ring-gray-800"></span>
                    @endif
                  </div>
                  
                  <div class="min-w-0">
                    <p class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $usuario->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $usuario->sexo ?? 'N/A' }} • {{ $usuario->area ?? 'Sin área' }}</p>
                  </div>
                </div>
              </td>

              {{-- Rol --}}
              <td class="px-3 py-3">
                @if($usuario->roles->isNotEmpty())
                  @php
                    $rol = $usuario->roles->first()->name;
                    $colores = [
                      'Administrador'          => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                      'Presidente Municipal'   => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                      'Síndico Procurador'     => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                      'Regidor'                => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                      'Director de Área'       => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                      'Auxiliar de Área'       => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                    ];
                  @endphp
                  <span class="inline-flex px-2 py-1 rounded-md text-xs font-semibold {{ $colores[$rol] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ Str::limit($rol, 15) }}
                  </span>
                @else
                  <span class="text-gray-400 text-xs">Sin rol</span>
                @endif
              </td>

              {{-- Correo --}}
              <td class="px-3 py-3">
                <a href="mailto:{{ $usuario->email }}" class="text-green-600 dark:text-green-400 hover:underline truncate block">
                  {{ $usuario->email }}
                </a>
              </td>

              {{-- Estado --}}
              <td class="px-3 py-3 text-center">
                @if(isUserOnline($usuario->id))
                  <span class="inline-flex items-center gap-1.5 text-xs bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2 py-1 rounded-md font-semibold">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Online
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 px-2 py-1 rounded-md font-semibold">
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                    Offline
                  </span>
                @endif
                <p class="text-xs text-gray-500 mt-1">
                  {{ $usuario->last_activity_at ? $usuario->last_activity_at->diffForHumans() : 'Nunca' }}
                </p>
              </td>

              {{-- Acciones --}}
              <td class="px-3 py-3">
                <div class="flex justify-center gap-1" x-data="{ openDelete: false }">
                  <a href="{{ route('usuarios.show', $usuario->id) }}"
                     class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition"
                     title="Ver">
                    <i class="ri-eye-line"></i>
                  </a>
                  <a href="{{ route('vista-editar-usuario', $usuario->id) }}"
                     class="p-2 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition"
                     title="Editar">
                    <i class="ri-edit-line"></i>
                  </a>

                  {{-- Botón que abre modal --}}
                  <button type="button"
                          @click="openDelete = true"
                          class="p-2 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-lg transition font-semibold"
                          title="Eliminar">
                    <i class="ri-delete-bin-line"></i>
                  </button>

                  {{-- Modal de confirmación --}}
                  <div x-show="openDelete"
                       x-cloak
                       class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-sm w-full mx-4 border border-red-200 dark:border-red-700">
                      <div class="px-4 py-3 border-b border-red-200 dark:border-red-700 flex items-center gap-2">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/40">
                          <i class="ri-error-warning-line text-red-600 dark:text-red-400"></i>
                        </div>
                        <h2 class="font-semibold text-red-700 dark:text-red-300 text-sm">
                          ¿Eliminar usuario?
                        </h2>
                      </div>

                      <div class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                        <p>Estás a punto de eliminar al usuario <span class="font-semibold">{{ $usuario->name }}</span>.</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                          Esta acción es permanente y no se puede deshacer.
                        </p>
                      </div>

                      <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-2">
                        <button type="button"
                                @click="openDelete = false"
                                class="px-3 py-1.5 text-xs sm:text-sm rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                          Cancelar
                        </button>

                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                                  class="px-3 py-1.5 text-xs sm:text-sm rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold">
                            Sí, eliminar
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-3 py-12 text-center">
                <div class="flex flex-col items-center text-gray-400 dark:text-gray-500">
                  <i class="ri-user-line text-4xl mb-2"></i>
                  <p class="font-medium">No hay usuarios</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
    @if($usuarios->hasPages())
      <div class="px-3 py-3 border-t border-gray-200 dark:border-gray-700">
        {{ $usuarios->links() }}
      </div>
    @endif
  </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
