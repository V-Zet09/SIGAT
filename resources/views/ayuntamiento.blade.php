@extends('layouts.master-public')

@section('title', 'Organigrama del Ayuntamiento')

@section('content')
<div class="max-w-full mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-[#00713D] mb-12 text-center">
        Organigrama del Ayuntamiento
    </h1>

    <!-- Alertas de éxito -->
    @if(session('success'))
    <div id="alert-success" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative animate-fade-in">
        <span class="block sm:inline">✅ {{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.remove()">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
    @endif

    @if($presidente)
        <div class="flex justify-center overflow-x-auto">
            <ul class="relative pl-0">
                <x-nodo-cargo :empleado="$presidente" />
            </ul>
        </div>
    @else
        <div class="text-center text-gray-500">
            <p>No hay datos del organigrama disponibles.</p>
        </div>
    @endif
</div>

<!-- Modal de Edición -->
<div id="modalEditar" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full mx-4 my-8 transform transition-all">
        <div class="bg-[#00713D] px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold text-yellow-300">✏️ Editar Cargo</h3>
            <button onclick="cerrarModal()" class="text-white bg-black bg-opacity-25 hover:bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center text-3xl leading-none">&times;</button>
        </div>

        
        <form id="formEditar" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nombre Completo *</label>
                    <input type="text" name="nombre" id="edit_nombre" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00713D]">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Puesto *</label>
                    <input type="text" name="puesto" id="edit_cargo" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00713D]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">Departamento</label>
                    <input type="text" name="departamento" id="edit_departamento"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00713D]">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="cerrarModal()" 
                        class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    Cancelar
                </button>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-[#00713D] text-white font-semibold rounded-lg hover:bg-[#005a2f] transition">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="modalEliminar" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-6 text-center">
            <div class="mb-4 text-red-500 text-6xl">⚠️</div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Confirmar Eliminación</h3>
            <p class="text-gray-600 mb-6">¿Estás seguro de eliminar este cargo? La posición quedará vacante pero se mantendrá en el organigrama.</p>
            
            <div class="flex gap-3">
                <button onclick="cerrarModalEliminar()" 
                        class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                    Cancelar
                </button>
                <button onclick="confirmarEliminar()" 
                        class="flex-1 px-6 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
                    Sí, Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="formEliminar" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.cargo-vacio {
    opacity: 0.6;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
    border: 2px dashed #cbd5e0 !important;
}

.cargo-vacio .avatar {
    background: #e2e8f0 !important;
}

.cargo-vacio .iniciales {
    color: #a0aec0 !important;
}
</style>

<script>
let cargoIdEliminar = null;

function abrirModalEditar(id, nombre, puesto, departamento) {
    const modal = document.getElementById('modalEditar');
    const form = document.getElementById('formEditar');
    
    form.action = `/ayuntamiento/${id}`;
    form.method = 'POST';
    
    document.getElementById('edit_nombre').value = nombre || '';
    document.getElementById('edit_cargo').value = puesto || '';
    document.getElementById('edit_departamento').value = departamento || '';
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function cerrarModal() {
    const modal = document.getElementById('modalEditar');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function abrirModalEliminar(id) {
    cargoIdEliminar = id;
    const modal = document.getElementById('modalEliminar');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function cerrarModalEliminar() {
    const modal = document.getElementById('modalEliminar');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    cargoIdEliminar = null;
}

function confirmarEliminar() {
    if (cargoIdEliminar) {
        const form = document.getElementById('formEliminar');
        form.action = `/ayuntamiento/${cargoIdEliminar}`;
        form.submit();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModal();
        cerrarModalEliminar();
    }
});

document.getElementById('modalEditar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});

document.getElementById('modalEliminar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalEliminar();
});

setTimeout(() => {
    const alert = document.getElementById('alert-success');
    if (alert) {
        alert.style.animation = 'fade-in 0.3s ease-out reverse';
        setTimeout(() => alert.remove(), 300);
    }
}, 5000);
</script>
@endsection
