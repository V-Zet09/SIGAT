@extends('layouts.master')
@section('title', 'Gestión de Actividades')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-6 transition-colors duration-500">

    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-green-700 dark:text-green-400 mb-1">GESTION DE ACTIVIDADES📋</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- TABLA IZQUIERDA: ACTIVIDADES POR REVISAR -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden border border-green-600 dark:border-green-700 relative">
            <div class="flex justify-between items-center bg-green-600 dark:bg-green-700 text-white px-5 py-3">
                <h2 class="text-lg font-semibold">Actividades por revisar </h2>
                <button onclick="openAddModal()" class="px-4 py-2 text-white font-semibold rounded-xl shadow-lg bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 transition transform hover:scale-105">+ Agregar</button>
            </div>

            <!-- Contenedor de actividades -->
            <div id="pending-activities" class="p-4 space-y-3">
                <div class="activity-item bg-green-50 dark:bg-[#2a2a2a] rounded-xl border border-green-300 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-center p-4">
                        <span class="font-semibold">Reunión con el comité de planeación</span>
                        <div class="flex items-center gap-3">
                            <button onclick="toggleDetails(this)" class="text-green-700 dark:text-green-300 hover:scale-110 transition" title="Ver información">
                                <i class="ri-file-list-3-line text-xl"></i>
                            </button>
                            <button onclick="openApproveModal(this)" class="text-green-600 dark:text-green-200 hover:scale-110 transition" title="Aprobar">
                                <i class="ri-checkbox-circle-line text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="activity-details hidden border-t border-green-200 dark:border-green-700 p-4 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                        Fecha: 15 de octubre<br>
                        Lugar: Sala de juntas<br>
                        Objetivo: Revisar avances del proyecto municipal
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLA DERECHA: ACTIVIDADES APROBADAS -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden border border-blue-600 dark:border-blue-700">
            <div class="bg-blue-600 dark:bg-blue-700 text-white text-center py-3">
                <h2 class="text-lg font-semibold">Actividades aprobadas </h2>
            </div>
            <div id="approved-activities" class="p-4 space-y-3">
                <!-- Aquí se moverán las actividades aprobadas -->
            </div>
        </div>
    </div>
</div>

<!-- MODAL INTERNO PARA AGREGAR ACTIVIDAD -->
<div id="add-modal" class="hidden fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-2xl w-96 max-w-full transform transition-all scale-95">
        <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Agregar nueva actividad</h3>

        <div id="error-msg" class="hidden mb-3 text-red-600 dark:text-red-400 text-sm"></div>

        <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Título de la actividad</label>
        <input id="activity-title" type="text" placeholder="Ej. Supervisión de obras públicas"
               class="w-full mb-3 px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-green-500 outline-none">

        <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Detalles</label>
        <textarea id="activity-details-input" rows="4" placeholder="Ej. - Revisar avances de construcción
- Comprobar materiales
- Supervisar equipo"
                  class="w-full mb-4 px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-green-500 outline-none"></textarea>

        <div class="flex justify-end gap-3">
            <button onclick="closeAddModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition">Cancelar</button>
            <button onclick="saveActivity()" class="px-4 py-2 bg-green-700 dark:bg-green-600 text-white rounded-md hover:bg-green-800 transition">Guardar</button>
        </div>
    </div>
</div>

<!-- MODAL INTERNO PARA CONFIRMAR APROBACIÓN -->
<div id="approve-modal" class="hidden fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-2xl w-80 max-w-full transform transition-all scale-95">
        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">Confirmar aprobación</h3>
        <p class="mb-4 text-gray-600 dark:text-gray-300">¿Estás seguro de aprobar esta actividad?</p>
        <div class="flex justify-end gap-3">
            <button onclick="closeApproveModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition">No</button>
            <button id="approve-btn" class="px-4 py-2 bg-green-700 dark:bg-green-600 text-white rounded-md hover:bg-green-800 transition">Sí, aprobar</button>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    // TOGGLE DETALLES (INDEPENDIENTE)
    function toggleDetails(btn) {
        const details = btn.closest('.activity-item').querySelector('.activity-details');
        details.classList.toggle('hidden');
        details.classList.toggle('animate-fadeIn');
    }

    // AGREGAR ACTIVIDAD
    function openAddModal() { document.getElementById('add-modal').classList.remove('hidden'); }
    function closeAddModal() {
        document.getElementById('error-msg').classList.add('hidden');
        document.getElementById('add-modal').classList.add('hidden');
    }

    function saveActivity() {
        const title = document.getElementById('activity-title').value.trim();
        const detailsText = document.getElementById('activity-details-input').value.trim();
        if (!title || !detailsText) {
            const error = document.getElementById('error-msg');
            error.textContent = "Por favor completa todos los campos.";
            error.classList.remove('hidden');
            return;
        }

        const container = document.getElementById('pending-activities');
        const newActivity = document.createElement('div');
        newActivity.className = 'activity-item bg-green-50 dark:bg-green-900 rounded-xl border border-green-300 dark:border-green-800 shadow-sm hover:shadow-md transition mt-2';
        newActivity.innerHTML = `
            <div class="flex justify-between items-center p-4">
                <span class="font-semibold">${title}</span>
                <div class="flex items-center gap-3">
                    <button onclick="toggleDetails(this)" class="text-green-700 dark:text-green-300 hover:scale-110 transition" title="Ver información">
                        <i class="ri-file-list-3-line text-xl"></i>
                    </button>
                    <button onclick="openApproveModal(this)" class="text-green-600 dark:text-green-200 hover:scale-110 transition" title="Aprobar">
                        <i class="ri-checkbox-circle-line text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="activity-details hidden border-t border-green-200 dark:border-green-700 p-4 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                ${detailsText}
            </div>
        `;
        container.appendChild(newActivity);

        document.getElementById('activity-title').value = '';
        document.getElementById('activity-details-input').value = '';
        closeAddModal();
    }

    // APROBAR ACTIVIDAD
    let currentActivity = null;
    function openApproveModal(btn) {
        currentActivity = btn.closest('.activity-item');
        document.getElementById('approve-modal').classList.remove('hidden');
    }
    function closeApproveModal() {
        currentActivity = null;
        document.getElementById('approve-modal').classList.add('hidden');
    }
    document.getElementById('approve-btn').addEventListener('click', function() {
        if (!currentActivity) return;
        const approvedContainer = document.getElementById('approved-activities');
        currentActivity.classList.remove('border-green-300', 'dark:border-green-800');
        currentActivity.classList.add('border-blue-300', 'dark:border-blue-700');
        currentActivity.querySelector('[title="Aprobar"]').remove();
        approvedContainer.appendChild(currentActivity);
        closeApproveModal();
    });
</script>

<!-- ANIMACIONES -->
<style>
@keyframes fadeIn { from {opacity:0; transform:translateY(-5px);} to{opacity:1; transform:translateY(0);} }
.animate-fadeIn { animation: fadeIn 0.3s ease-in-out; }
</style>
@endsection
