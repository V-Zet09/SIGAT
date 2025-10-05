@extends('layouts.master')

@section('title', 'Informes Generados')

@section('css')
<script src="https://cdn.tailwindcss.com"></script>
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
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .table-row {
        transition: all 0.2s ease;
    }
    
    .table-row:hover {
        background: linear-gradient(to right, #f0fdf4, #dcfce7);
        transform: scale(1.01);
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
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
</style>
@endsection

@section('content')

    <div class="mx-auto" style="max-width: 95%;">
        <div class="rounded-3xl bg-white shadow-2xl p-6">
        
        <!-- Header -->
        <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 p-6 shadow-xl animate-fade-in-up">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white opacity-10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 rounded-full bg-white opacity-10"></div>
            
            <div class="relative z-10 flex items-center justify-between">
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

        <!-- Mensaje de éxito -->
        @if(session('success'))
        <div class="alert mb-6 animate-slide-in-right rounded-xl border-l-4 border-green-500 bg-green-50 p-4 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-xl text-green-500"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-base font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <div class="mb-6 grid gap-4 md:grid-cols-2 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="glass-effect rounded-xl p-4 shadow-lg">
                <div class="flex space-x-2">
                    <a href="{{ route('informes-generados') }}" 
                       class="flex-1 rounded-lg px-4 py-2 text-center text-base font-medium transition {{ !request('filtro') ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-green-50' }}">
                        <i class="fas fa-th-list mr-2"></i>Todos
                    </a>
                    <a href="{{ route('informes-generados', ['filtro' => 'recientes']) }}" 
                       class="flex-1 rounded-lg px-4 py-2 text-center text-base font-medium transition {{ request('filtro') == 'recientes' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-green-50' }}">
                        <i class="fas fa-clock mr-2"></i>Recientes
                    </a>
                    <a href="{{ route('informes-generados', ['filtro' => 'antiguos']) }}" 
                       class="flex-1 rounded-lg px-4 py-2 text-center text-base font-medium transition {{ request('filtro') == 'antiguos' ? 'bg-green-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-green-50' }}">
                        <i class="fas fa-history mr-2"></i>Antiguos
                    </a>
                </div>
            </div>
            
            <div class="glass-effect rounded-xl p-4 shadow-lg">
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Buscar informes..." 
                           class="w-full rounded-lg border-0 bg-white py-3 pl-12 pr-4 text-base text-gray-700 shadow-inner focus:ring-2 focus:ring-green-500">
                    <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Estadísticas Cards -->
        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="stat-card glass-effect rounded-xl p-5 shadow-xl animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Informes Totales</p>
                        <h3 class="mt-1 text-3xl font-bold text-green-600">{{ $totalInformes }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 shadow-lg">
                        <i class="fas fa-file-alt text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Documentos oficiales</span>
                </div>
            </div>

            <div class="stat-card glass-effect rounded-xl p-5 shadow-xl animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Este Mes</p>
                        <h3 class="mt-1 text-3xl font-bold text-blue-600">{{ $informesEsteMes }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 shadow-lg">
                        <i class="fas fa-calendar text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-blue-600">
                    <i class="fas fa-calendar-check mr-1"></i>
                    <span>Periodo actual</span>
                </div>
            </div>

            <div class="stat-card glass-effect rounded-xl p-5 shadow-xl animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Descargas</p>
                        <h3 class="total-descargas mt-1 text-3xl font-bold text-purple-600">{{ $totalDescargas }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-purple-400 to-pink-500 shadow-lg">
                        <i class="fas fa-download text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-purple-600">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>Total de accesos</span>
                </div>
            </div>

            <div class="stat-card glass-effect rounded-xl p-5 shadow-xl animate-fade-in-up" style="animation-delay: 0.5s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Último Informe</p>
                        <h3 class="mt-1 text-lg font-bold text-orange-600">{{ $ultimoInforme }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-orange-400 to-red-500 shadow-lg">
                        <i class="fas fa-clock text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm text-orange-600">
                    <i class="fas fa-history mr-1"></i>
                    <span>Actualización reciente</span>
                </div>
            </div>
        </div>

        <!-- Tabla de Informes -->
        <div class="glass-effect rounded-xl shadow-2xl animate-fade-in-up" style="animation-delay: 0.6s">
            <div class="border-b border-gray-200 bg-white/50 px-6 py-4 rounded-t-xl">
                <h2 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-folder-open mr-2 text-green-600"></i>
                    Listado de Informes
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="sticky top-0 bg-gray-50">
                        <tr class="border-b border-gray-200 text-left text-sm font-semibold text-gray-700">
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-file-alt text-green-600"></i>
                                    <span>Título del Informe</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar-alt text-blue-600"></i>
                                    <span>Período</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                                    <span>Municipio</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock text-orange-600"></i>
                                    <span>Fecha</span>
                                </div>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-download text-indigo-600"></i>
                                    <span>Descargas</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-cog text-gray-600"></i>
                                    <span>Acciones</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="informesTableBody" class="divide-y divide-gray-200 bg-white">
                        @forelse($informes as $informe)
                        <tr class="table-row" data-informe-id="{{ $informe->id }}" data-titulo="{{ strtolower($informe->titulo) }}" data-periodo="{{ strtolower($informe->periodo) }}" data-municipio="{{ strtolower($informe->municipio_nombre ?? '') }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                                        <i class="fas fa-file-invoice text-green-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $informe->titulo }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $informe->periodo }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700">{{ $informe->municipio_nombre ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $informe->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-sm font-bold text-purple-800" id="descargas-{{ $informe->id }}">
                                    <i class="fas fa-download mr-2"></i>
                                    {{ $informe->descargas ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
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
                                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-700">No hay informes generados</h3>
                                        <p class="mt-2 text-sm text-gray-500">Comienza creando tu primer informe gubernamental</p>
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
            <div class="glass-effect rounded-xl px-4 py-2 shadow-lg">
                {{ $informes->links() }}
            </div>
        </div>
        @endif

        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="modal">
    <div class="modal-content bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4">
        <div class="text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">¿Eliminar Informe?</h3>
            <p class="text-gray-600 mb-6">Esta acción no se puede deshacer. El informe será eliminado permanentemente.</p>
            
            <div class="flex space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 rounded-lg border-2 border-gray-300 bg-white px-4 py-3 text-base font-semibold text-gray-700 transition hover:bg-gray-50">
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
    <div class="modal-content bg-white rounded-2xl shadow-2xl mx-8 my-8 w-full max-w-6xl max-h-screen overflow-hidden flex flex-col">
        <div class="flex items-center justify-between border-b border-gray-200 p-6">
            <h3 class="text-2xl font-bold text-gray-900">
                <i class="fas fa-edit mr-2 text-blue-600"></i>
                Editar Informe
            </h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título del Informe</label>
                    <input type="text" id="edit-titulo" name="titulo" 
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 text-base">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contenido</label>
                    <div id="editor-container" class="bg-white border rounded-lg"></div>
                    <textarea id="edit-content" name="introduccion" class="hidden"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditModal()" 
                            class="rounded-lg border-2 border-gray-300 bg-white px-6 py-3 text-base font-semibold text-gray-700 transition hover:bg-gray-50">
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
                            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                                <i class="fas fa-search text-4xl text-gray-400"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">No se encontraron resultados</h3>
                                <p class="mt-2 text-sm text-gray-500">No hay informes que coincidan con "${searchTerm}"</p>
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

// Auto-cerrar alertas
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.transition = 'opacity 0.5s, transform 0.5s';
        alert.style.opacity = '0';
        alert.style.transform = 'translateX(100%)';
        setTimeout(() => alert.remove(), 500);
    });
}, 3000);
</script>
@endsection