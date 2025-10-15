@extends('layouts.master')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6 transition-colors duration-300">

    <!-- Header -->
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
        ¡Hola, Administrador!
    </h1>

    <!-- Grid de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold">Actividades</h2>
            <p class="text-2xl font-bold">4</p>
            <span class="text-xs text-gray-500 dark:text-gray-400">Registradas</span>
        </div>
        <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold">Total orders</h2>
            <p class="text-2xl font-bold">2025</p>
            <span class="text-xs text-gray-500 dark:text-gray-400">Últimos 7 días</span>
        </div>
        <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold">Completadas</h2>
            <p class="text-2xl font-bold">16,247</p>
            <span class="text-xs text-gray-500 dark:text-gray-400">Pending payment</span>
        </div>
        <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-sm font-semibold">Usuarios activos</h2>
            <p class="text-2xl font-bold">4</p>
        </div>
    </div>

    <!-- Cards informativos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold mb-2">Estado general</h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center">
                    <span class="text-green-500 mr-2">✔</span> Actividades reguladas
                </li>
                <li class="flex items-center">
                    <span class="text-yellow-500 mr-2">⧗</span> Actividades en revisión
                </li>
                <li class="flex items-center">
                    <span class="text-blue-500 mr-2">👤</span> Usuarios activos
                </li>
                <li class="flex items-center">
                    <span class="text-gray-500 mr-2">📅</span> Reporte anual 2023-2025
                </li>
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold mb-2">Historial</h3>
            <p class="text-sm mb-1">📌 Título anterior: <span class="font-semibold">Lleva 7 años</span></p>
            <p class="text-sm mb-1">✅ Estado: Cumplido</p>
            <p class="text-sm mb-1">📝 Puedes presentar</p>
            <p class="text-sm">📂 Aprobación con área</p>
        </div>
    </div>

    <div class="divider"></div>

    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>4 actividades en revisión</h4>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <div class="highlight">16,247</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>Actividades por área</h4>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <h4>4 usuarios activos</h4>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="dashboard-card">
                <h4>2025</h4>
                <div class="highlight">45 actividades registradas</div>
            </div>
        </div>
    </div>

    <!-- Manteniendo tus secciones originales -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Actividades reguladas</h4>
                    <ul class="list-unstyled">
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> Actividades reguladas</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> Actividades en revistas</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> Usuarios activos</li>
                        <li><i class="mdi mdi-check-circle text-success me-2"></i> 2023 a actividades reguladas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Título anterior</h4>
                    <p class="text-muted mb-0">Lleva 7 años</p>
                    
                    <div class="mt-4">
                        <h4 class="card-title mb-4">Cumplido</h4>
                        <p class="text-muted">Puedes presentar</p>
                    </div>
                    
                    <div class="mt-4">
                        <h4 class="card-title mb-4">Aprobación con área</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th>Actividades</th>
                                    <th>Usuarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Enero</td>
                                    <td>120</td>
                                    <td>85</td>
                                </tr>
                                <tr>
                                    <td>Febrero</td>
                                    <td>150</td>
                                    <td>92</td>
                                </tr>
                                <tr>
                                    <td>Marzo</td>
                                    <td>180</td>
                                    <td>110</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
        </div>
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Mes</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actividades</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Usuarios</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4">Enero</td>
                    <td class="px-6 py-4">120</td>
                    <td class="px-6 py-4">85</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Febrero</td>
                    <td class="px-6 py-4">150</td>
                    <td class="px-6 py-4">92</td>
                </tr>
                <tr>
                    <td class="px-6 py-4">Marzo</td>
                    <td class="px-6 py-4">180</td>
                    <td class="px-6 py-4">110</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
