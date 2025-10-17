@extends('layouts.master')

@section('title', 'Informes Generados')

@section('css')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    // Configurar Tailwind para usar clase manual en lugar de media query
    tailwind.config = {
        darkMode: 'class',
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .table-row {
        transition: all 0.2s ease;
    }
    
    .table-row:hover {
        transform: scale(1.01);
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        animation: slideUp 0.3s;
    }

    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    #editor-container {
        height: 70vh;
    }

    /* Dark mode para Quill */
    .dark .ql-toolbar {
        background-color: #374151;
        border-color: #4b5563;
    }

    .dark .ql-container {
        background-color: #1f2937;
        border-color: #4b5563;
    }

    .dark .ql-editor {
        color: #f3f4f6;
    }

    .dark .ql-stroke {
        stroke: #9ca3af;
    }

    .dark .ql-fill {
        fill: #9ca3af;
    }

    .dark .ql-picker-label {
        color: #9ca3af;
    }
</style>
@endsection

@section('content')

<!-- Toast de Éxito (Emergente) -->
@if(session('success'))
<div id="successToast" 
     class="fixed top-6 right-6 max-w-md bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-800 dark:to-emerald-900 text-white rounded-xl shadow-2xl overflow-hidden z-50 transform transition-all duration-500 ease-out"
     style="animation: slideIn 0.5s ease-out, slideOut 0.5s ease-in 2.5s forwards;">
    <div class="relative">
        <div class="p-5">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex-1">
                    <h3 class="text-lg font-bold mb-1 flex items-center gap-2">
                        ✓ ¡Éxito!
                    </h3>
                    <p class="text-sm text-green-100">{{ session('success') }}</p>
                </div>
                
                <button onclick="document.getElementById('successToast').remove()" 
                        class="flex-shrink-0 text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="h-1 bg-green-800 dark:bg-green-950">
            <div class="h-full bg-green-300 dark:bg-green-500" style="animation: progress 3s linear;"></div>
        </div>
    </div>
</div>

<script>
    // Auto-eliminar el toast después de 3 segundos
    setTimeout(() => {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.remove();
        }
    }, 3000);
</script>
@endif

<!-- Toast de Error (Emergente) -->
@if($errors->any())
<div id="errorToast" 
     class="fixed top-6 right-6 max-w-md bg-gradient-to-r from-red-600 to-red-700 dark:from-red-800 dark:to-red-900 text-white rounded-xl shadow-2xl overflow-hidden z-50 transform transition-all duration-500 ease-out"
     style="animation: slideIn 0.5s ease-out;">
    <div class="relative">
        <div class="p-5">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex-1">
                    <h3 class="text-lg font-bold mb-2">⚠️ Error</h3>
                    <ul class="space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <span class="text-red-300">→</span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <button onclick="document.getElementById('errorToast').remove()" 
                        class="flex-shrink-0 text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="h-1 bg-red-800 dark:bg-red-950">
            <div class="h-full bg-red-300 dark:bg-red-500" style="animation: progress 5s linear;"></div>
        </div>
    </div>
</div>

<script>
    // Auto-eliminar el toast de error después de 5 segundos
    setTimeout(() => {
        const toast = document.getElementById('errorToast');
        if (toast) {
            toast.style.animation = 'slideOut 0.5s ease-in forwards';
            setTimeout(() => toast.remove(), 500);
        }
    }, 5000);
</script>
@endif

<div class="mx-auto px-4" style="max-width: 95%;">
    <div class="rounded-3xl bg-white dark:bg-gray-800 shadow-2xl p-6">
    
        <!-- Header -->
        <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 dark:from-green-700 dark:via-emerald-700 dark:to-teal-700 p-6 shadow-xl animate-fade-in-up">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 rounded-full bg-white dark:bg-gray-900 opacity-10"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                        <i class="fas fa-landmark text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Informes de Gobierno</h1>
                        <p class="text-base text-green-100">Gestión de informes gubernamentales y reportes institucionales</p>
                    </div>
                </div>
                
                <a href="{{ route('generar-informe') }}" class="group flex items-center space-x-2 rounded-lg bg-white px-6 py-3 text-base font-semibold text-green-600 shadow-lg transition hover:scale-105">
                    <i class="fas fa-plus-circle text-lg transition group-hover:rotate-90"></i>
                    <span>Nuevo Informe</span>
                </a>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="mb-6 grid gap-4 md:grid-cols-2 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-white/30 dark:border-gray-600/30">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('informes-generados') }}" 
                       class="flex-1 min-w-[100px] rounded-lg px-4 py-2 text-center text-base font-medium transition {{ !request('filtro') ? 'bg-green-600 text-white shadow-lg' : 'bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-500' }}">
                        <i class="fas fa-th-list mr-2"></i>Todos
                    </a>
                    <a href="{{ route('informes-generados', ['filtro' => 'recientes']) }}" 
                       class="flex-1 min-w-[100px] rounded-lg px-4 py-2 text-center text-base font-medium transition {{ request('filtro') == 'recientes' ? 'bg-green-600 text-white shadow-lg' : 'bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-500' }}">
                        <i class="fas fa-clock mr-2"></i>Recientes
                    </a>
                    <a href="{{ route('informes-generados', ['filtro' => 'antiguos']) }}" 
                       class="flex-1 min-w-[100px] rounded-lg px-4 py-2 text-center text-base font-medium transition {{ request('filtro') == 'antiguos' ? 'bg-green-600 text-white shadow-lg' : 'bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-500' }}">
                        <i class="fas fa-history mr-2"></i>Antiguos
                    </a>
                </div>
            </div>
            
            <div class="bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-white/30 dark:border-gray-600/30">
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Buscar informes..." 
                           class="w-full rounded-lg border-0 bg-white dark:bg-gray-600 py-3 pl-12 pr-4 text-base text-gray-700 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 shadow-inner focus:ring-2 focus:ring-green-500">
                    <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Estadísticas Cards -->
        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="stat-card bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-5 shadow-xl border border-white/30 dark:border-gray-600/30 animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Informes Totales</p>
                        <h3 class="mt-1 text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalInformes }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 shadow-lg">
                        <i class="fas fa-file-alt text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-green-600 dark:text-green-400">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Documentos oficiales</span>
                </div>
            </div>

            <div class="stat-card bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-5 shadow-xl border border-white/30 dark:border-gray-600/30 animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Este Mes</p>
                        <h3 class="mt-1 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $informesEsteMes }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 shadow-lg">
                        <i class="fas fa-calendar text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-blue-600 dark:text-blue-400">
                    <i class="fas fa-calendar-check mr-1"></i>
                    <span>Periodo actual</span>
                </div>
            </div>

            <div class="stat-card bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-5 shadow-xl border border-white/30 dark:border-gray-600/30 animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Descargas</p>
                        <h3 class="total-descargas mt-1 text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalDescargas }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-purple-400 to-pink-500 shadow-lg">
                        <i class="fas fa-download text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-purple-600 dark:text-purple-400">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>Total de accesos</span>
                </div>
            </div>

            <div class="stat-card bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl p-5 shadow-xl border border-white/30 dark:border-gray-600/30 animate-fade-in-up" style="animation-delay: 0.5s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Último Informe</p>
                        <h3 class="mt-1 text-lg font-bold text-orange-600 dark:text-orange-400">{{ $ultimoInforme }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-orange-400 to-red-500 shadow-lg">
                        <i class="fas fa-clock text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-orange-600 dark:text-orange-400">
                    <i class="fas fa-history mr-1"></i>
                    <span>Actualización reciente</span>
                </div>
            </div>
        </div>

        <!-- Tabla de Informes -->
        <div class="bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl shadow-2xl border border-white/30 dark:border-gray-600/30 animate-fade-in-up" style="animation-delay: 0.6s">
            <div class="border-b border-gray-200 dark:border-gray-600 bg-white/50 dark:bg-gray-700/50 px-6 py-4 rounded-t-xl">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    <i class="fas fa-folder-open mr-2 text-green-600 dark:text-green-400"></i>
                    Listado de Informes
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="sticky top-0 bg-gray-50 dark:bg-gray-800">
                        <tr class="border-b border-gray-200 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-file-alt text-green-600 dark:text-green-400"></i>
                                    <span>Título del Informe</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400"></i>
                                    <span>Período</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-marker-alt text-purple-600 dark:text-purple-400"></i>
                                    <span>Municipio</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock text-orange-600 dark:text-orange-400"></i>
                                    <span>Fecha</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-download text-indigo-600 dark:text-indigo-400"></i>
                                    <span>Descargas</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-cog text-gray-600 dark:text-gray-400"></i>
                                    <span>Acciones</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="informesTableBody" class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
                        @forelse($informes as $informe)
                        <tr class="table-row hover:bg-green-50 dark:hover:bg-gray-700" data-informe-id="{{ $informe->id }}" data-titulo="{{ strtolower($informe->titulo) }}" data-periodo="{{ strtolower($informe->periodo) }}" data-municipio="{{ strtolower($informe->municipio_nombre ?? '') }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                                        <i class="fas fa-file-invoice text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $informe->titulo }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-sm font-medium text-blue-800 dark:text-blue-300">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $informe->periodo }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $informe->municipio_nombre ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $informe->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-purple-100 dark:bg-purple-900/30 px-3 py-1 text-sm font-bold text-purple-800 dark:text-purple-300" id="descargas-{{ $informe->id }}">
                                    <i class="fas fa-download mr-2"></i>
                                    {{ $informe->descargas ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center flex-wrap gap-2">
                                    @if(true)
                                    <a href="{{ route('informes.download', $informe->id) }}" 
                                        onclick="descargarInforme('{{ route('informes.download', $informe->id) }}', {{ $informe->id }}); return true;"
                                        class="group flex items-center space-x-2 rounded-lg bg-red-500 px-3 py-2 text-sm font-medium text-white shadow-md transition hover:bg-red-600">
                                        <i class="fas fa-file-pdf transition group-hover:scale-110"></i>
                                        <span>PDF</span>
                                    </a>
                                    @endif
                                    
                                    <button onclick="openEditModal({{ $informe->id }}, '{{ $informe->titulo }}', `{{ addslashes($informe->introduccion ?? '') }}`)" 
                                       class="group flex items-center space-x-2 rounded-lg bg-blue-500 px-3 py-2 text-sm font-medium text-white shadow-md transition hover:bg-blue-600">
                                        <i class="fas fa-edit transition group-hover:scale-110"></i>
                                        <span>Editar</span>
                                    </button>
                                    
                                    <button onclick="confirmDelete({{ $informe->id }})" 
                                            class="group flex items-center space-x-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white shadow-md transition hover:bg-red-700">
                                        <i class="fas fa-trash transition group-hover:scale-110"></i>
                                        <span>Eliminar</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="noResultsRow">
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                                        <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">No hay informes generados</h3>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primer informe gubernamental</p>
                                    </div>
                                    <a href="{{ route('generar-informe') }}" 
                                       class="mt-4 inline-flex items-center space-x-2 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition hover:scale-105">
                                        <i class="fas fa-plus-circle"></i>
                                        <span>Crear Primer Informe</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($informes->hasPages())
        <div class="mt-6 flex justify-center animate-fade-in-up" style="animation-delay: 0.7s">
            <div class="bg-white/70 dark:bg-gray-700/50 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg border border-white/30 dark:border-gray-600/30">
                {{ $informes->links() }}
            </div>
        </div>
        @endif

    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="modal">
    <div class="modal-content bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-md mx-4">
        <div class="text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600 dark:text-red-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">¿Eliminar Informe?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Esta acción no se puede deshacer. El informe será eliminado permanentemente.</p>
            
            <div class="flex space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-base font-semibold text-gray-700 dark:text-gray-200 transition hover:bg-gray-50 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full rounded-lg bg-red-600 px-4 py-3 text-base font-semibold text-white shadow-lg transition hover:bg-red-700">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edición -->
<div id="editModal" class="modal">
    <div class="modal-content bg-white dark:bg-gray-800 rounded-2xl shadow-2xl mx-8 my-8 w-full max-w-6xl max-h-screen overflow-hidden flex flex-col">
        <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                <i class="fas fa-edit mr-2 text-blue-600 dark:text-blue-400"></i>
                Editar Informe
            </h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Título del Informe</label>
                    <input type="text" id="edit-titulo" name="titulo" 
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 text-base">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenido</label>
                    <div id="editor-container" class="bg-white dark:bg-gray-900 border dark:border-gray-600 rounded-lg"></div>
                    <textarea id="edit-content" name="introduccion" class="hidden"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditModal()" 
                            class="rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-6 py-3 text-base font-semibold text-gray-700 dark:text-gray-200 transition hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="rounded-lg bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script>
let quillEditor;
let noResultsMessage = null;

// Función para descargar informe CON actualización en tiempo real
function descargarInforme(url, informeId) {
    console.log('Descargando informe ID:', informeId);
    console.log('URL:', url);
    
    // Esperar 1 segundo después del click para actualizar contadores
    setTimeout(function() {
        console.log('Actualizando contadores...');
        
        // Actualizar contador individual
        fetch(`/informe/${informeId}/download-count`)
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta servidor:', data);
                if(data.success) {
                    // Actualizar contador individual en la tabla
                    const descargasElement = document.getElementById(`descargas-${informeId}`);
                    if(descargasElement) {
                        descargasElement.innerHTML = `<i class="fas fa-download mr-2"></i>${data.descargas}`;
                        console.log('Contador individual actualizado:', data.descargas);
                    }
                    
                    // Actualizar contador total
                    actualizarContadorTotal();
                }
            })
            .catch(error => console.error('Error al actualizar contador:', error));
    }, 1000);
}

// Función para actualizar el contador total
function actualizarContadorTotal() {
    fetch('/dashboard-informes-generados/stats')
        .then(response => response.json())
        .then(data => {
            console.log('Stats totales:', data);
            if(data.success) {
                const totalElement = document.querySelector('.total-descargas');
                if(totalElement) {
                    totalElement.textContent = data.totalDescargas;
                    console.log('Total de descargas actualizado:', data.totalDescargas);
                }
            }
        })
        .catch(error => console.error('Error al actualizar stats:', error));
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado');
    
    // Inicializar Quill
    const editorContainer = document.getElementById('editor-container');
    if (editorContainer) {
        quillEditor = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });
    }

    // Buscador
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('informesTableBody');
    const tableRows = document.querySelectorAll('#informesTableBody tr.table-row');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const titulo = row.getAttribute('data-titulo') || '';
                const periodo = row.getAttribute('data-periodo') || '';
                const municipio = row.getAttribute('data-municipio') || '';

                const matchFound = titulo.includes(searchTerm) || 
                                 periodo.includes(searchTerm) || 
                                 municipio.includes(searchTerm);

                if (matchFound || searchTerm === '') {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResultsMessage) {
                noResultsMessage.remove();
                noResultsMessage = null;
            }

            if (visibleCount === 0 && searchTerm !== '') {
                noResultsMessage = document.createElement('tr');
                noResultsMessage.innerHTML = `
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                                <i class="fas fa-search text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">No se encontraron resultados</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No hay informes que coincidan con "${searchTerm}"</p>
                            </div>
                        </div>
                    </td>
                `;
                tableBody.appendChild(noResultsMessage);
            }
        });
    }
});

// Modal de eliminación
function confirmDelete(id) {
    document.getElementById('deleteForm').action = `/informes/${id}`;
    document.getElementById('deleteModal').classList.add('active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Modal de edición
function openEditModal(id, titulo, contenido) {
    if (quillEditor) {
        document.getElementById('edit-titulo').value = titulo;
        quillEditor.root.innerHTML = contenido;
        document.getElementById('editForm').action = `/informes/${id}`;
        document.getElementById('editModal').classList.add('active');
    }
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

// Enviar formulario de edición
const editForm = document.getElementById('editForm');
if (editForm) {
    editForm.addEventListener('submit', function(e) {
        if (quillEditor) {
            document.getElementById('edit-content').value = quillEditor.root.innerHTML;
        }
    });
}

// Cerrar modales al hacer clic fuera
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
}
</script>
@endsection