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

    <!-- Tabla -->
    <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-2xl shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold">Actividades por mes</h3>
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
