@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/crm-leads.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Manejo de dropdowns
    document.querySelectorAll('[data-dropdown-button]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const menu = button.nextElementSibling;
            
            // Cerrar otros menús
            document.querySelectorAll('[data-dropdown-menu]').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            
            menu.classList.toggle('hidden');
        });
    });

    // Cerrar menú al hacer click fuera
    window.addEventListener('click', () => {
        document.querySelectorAll('[data-dropdown-menu]').forEach(menu => {
            menu.classList.add('hidden');
        });
    });

    // Asegurar que el modal esté oculto al cargar
    const modal = document.getElementById('deleteRecordModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    // Eliminar backdrop si existe
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
});

// Funciones del modal
function confirmarEliminacion(url, nombre) {
    const form = document.getElementById('form-eliminar');
    const modal = document.getElementById('deleteRecordModal');
    const nombreElement = document.getElementById('usuario-nombre-eliminar');
    
    form.action = url;
    nombreElement.textContent = nombre;
    
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    document.getElementById('confirmar-eliminar').onclick = function() {
        form.submit();
    };
}

function cerrarModal() {
    const modal = document.getElementById('deleteRecordModal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

// Cerrar modal con ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        cerrarModal();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('deleteRecordModal')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) {
        cerrarModal();
    }
});
</script>
@endsection
@extends('layouts.master')
@section('title')
    @lang('translation.leads')
@endsection

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<style>
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- Breadcrumb --}}
    <nav class="flex mb-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1">
            <li class="inline-flex items-center">
                <a href="#" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                    CRM
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Usuarios</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <span class="text-2xl">👤</span> Registro General de Usuarios
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestiona todos los usuarios del sistema</p>
    </div>

    {{-- Card Principal --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        {{-- Barra de Acciones --}}
        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row gap-3 justify-between items-start md:items-center">
                {{-- Buscador --}}
                <div class="w-full md:w-80">
                    <div class="relative">
                        <input type="text" 
                               class="form-control search w-full px-3 py-2 pl-9 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent" 
                               placeholder="Buscar usuarios...">
                        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400 dark:text-gray-500"></i>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex gap-2">
                    <button class="btn btn-soft-danger px-3 py-2 text-sm rounded-lg" id="remove-actions" onClick="deleteMultiple()">
                        <i class="ri-delete-bin-2-line"></i>
                    </button>
                    <button type="button" class="btn btn-info px-3 py-2 text-sm rounded-lg inline-flex items-center gap-1">
                        <i class="ri-filter-3-line"></i>
                        <span class="hidden md:inline">Filtros</span>
                    </button>
                    <a href="{{ route('dashboard-crear-usuario') }}" 
                       class="btn btn-success px-3 py-2 text-sm rounded-lg inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white transition">
                        <i class="ri-add-line"></i>
                        <span>Nuevo Usuario</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="customerTable">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-4 py-3 w-10">
                            <input id="checkAll" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                        </th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-left">
                            Nombre
                        </th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-left">
                            Sexo
                        </th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-left">
                            Cargo
                        </th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-left">
                            Área
                        </th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-left">
                            Correo
                        </th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider text-center w-24">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @php
                        if (!isset($usuarios)) {
                            $usuarios = \App\Models\User::all();
                        }
                    @endphp

                    @forelse ($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="chk_child" value="{{ $usuario->id }}"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $usuario->name }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                {{ $usuario->sexo ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ $usuario->cargo ?? 'Sin cargo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                    {{ $usuario->area ?? 'Sin área' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-sm">
                                {{ $usuario->email }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="relative inline-block text-left">
                                    <button type="button" 
                                        class="inline-flex items-center justify-center w-full px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                        data-dropdown-button>
                                        <i class="ri-more-2-fill text-lg"></i>
                                    </button>

                                    <div class="hidden origin-top-right absolute right-0 mt-2 w-44 rounded-lg shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50 overflow-hidden"
                                        data-dropdown-menu>
                                        <div class="py-1">
                                            <a href="{{ route('vista-ver-usuarios', $usuario->id) }}" 
                                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                                <i class="ri-eye-line text-blue-600 dark:text-blue-400 text-lg"></i>
                                                <span>Ver detalles</span>
                                            </a>
                                            <a href="{{ route('vista-editar-usuario', ['id' => $usuario->id]) }}" 
                                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                                <i class="ri-edit-line text-yellow-600 dark:text-yellow-400 text-lg"></i>
                                                <span>Editar</span>
                                            </a>
                                            <button type="button"
                                                onclick="confirmarEliminacion('{{ route('usuarios.destroy', $usuario->id) }}', '{{ $usuario->name }}')"
                                                class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                                <i class="ri-delete-bin-line text-red-600 dark:text-red-400 text-lg"></i>
                                                <span>Eliminar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ri-user-line text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                    <h3 class="text-base font-medium text-gray-900 dark:text-gray-100 mb-1">No hay usuarios registrados</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Comienza agregando tu primer usuario</p>
                                    <a href="{{ route('dashboard-crear-usuario') }}" class="btn btn-success px-3 py-2 text-sm rounded-lg">
                                        <i class="ri-add-line me-1"></i> Agregar Usuario
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mensaje "No Result" --}}
        <div class="noresult hidden p-8 text-center">
            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                trigger="loop" colors="primary:#121331,secondary:#08a88a"
                style="width:60px;height:60px">
            </lord-icon>
            <h5 class="mt-3 text-base font-medium text-gray-900 dark:text-gray-100">No se encontraron resultados</h5>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Intenta con otros términos de búsqueda</p>
        </div>

        {{-- Paginación --}}
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
            <div class="flex justify-end">
                <div class="pagination-wrap hstack gap-2">
                    <a class="page-item pagination-prev disabled px-3 py-1.5 text-sm rounded-lg text-gray-600 dark:text-gray-400" href="#">
                        <i class="ri-arrow-left-line me-1"></i> Anterior
                    </a>
                    <ul class="pagination listjs-pagination mb-0 flex gap-1"></ul>
                    <a class="page-item pagination-next px-3 py-1.5 text-sm rounded-lg text-gray-600 dark:text-gray-400" href="#">
                        Siguiente <i class="ri-arrow-right-line ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Confirmación Mejorado --}}
<div id="deleteRecordModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="p-6">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Confirmar Eliminación</h3>
                </div>
                <button type="button" 
                        onclick="cerrarModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            {{-- Contenido --}}
            <div class="text-center py-4">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                    <i class="ri-error-warning-line text-3xl text-red-600 dark:text-red-400"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                    ¿Estás seguro de eliminar este usuario?
                </h4>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-1" id="usuario-nombre-eliminar"></p>
                <p class="text-gray-500 dark:text-gray-500 text-xs">
                    Esta acción no se puede deshacer
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3 mt-6">
                <button type="button" 
                        onclick="cerrarModal()"
                        class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition font-medium">
                    Cancelar
                </button>
                <button type="button" 
                        id="confirmar-eliminar"
                        class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-medium">
                    <i class="ri-delete-bin-line me-1"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Formulario oculto para eliminación --}}
<form id="form-eliminar" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/crm-leads.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Asegurar que el modal esté oculto al cargar
    const modal = document.getElementById('deleteRecordModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    // Eliminar backdrop si existe
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
});

// Funciones del modal
function confirmarEliminacion(url, nombre) {
    const form = document.getElementById('form-eliminar');
    const modal = document.getElementById('deleteRecordModal');
    const nombreElement = document.getElementById('usuario-nombre-eliminar');
    
    form.action = url;
    nombreElement.textContent = nombre;
    
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    document.getElementById('confirmar-eliminar').onclick = function() {
        form.submit();
    };
}

function cerrarModal() {
    const modal = document.getElementById('deleteRecordModal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

// Cerrar modal con ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        cerrarModal();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('deleteRecordModal')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) {
        cerrarModal();
    }
});
</script>
@endsection