@extends('layouts.master')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">

    <!-- Header -->
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
        ¡Hola, Administrador!
    </h1>

    <!-- Estadísticas principales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow text-center">
            <h2 class="text-sm font-semibold">Actividades</h2>
            <p class="text-2xl font-bold">{{ $totalActividades }}</p>
            <span class="text-xs text-gray-500">Registros totales</span>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow text-center">
            <h2 class="text-sm font-semibold">Usuarios</h2>
            <p class="text-2xl font-bold">{{ $totalUsuarios }}</p>
            <span class="text-xs text-gray-500">Activos</span>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow text-center">
            <h2 class="text-sm font-semibold">Informes</h2>
            <p class="text-2xl font-bold">{{ $totalInformes }}</p>
            <span class="text-xs text-gray-500">Generados</span>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h3 class="text-lg font-bold mb-2">Acciones rápidas</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('actividades.create') }}" class="btn btn-primary">Registrar Actividad</a>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Ver Usuarios</a>
                <a href="{{ route('informes-generados') }}" class="btn btn-info">Generar Informe</a>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h3 class="text-lg font-bold mb-2">Estado general</h3>
            <ul class="space-y-2 text-sm">
                <li><span class="text-green-500">✔</span> {{ $actividadesRevisadas }} actividades revisadas</li>
                <li><span class="text-yellow-500">⧗</span> {{ $actividadesPendientes }} actividades pendientes</li>
                <li><span class="text-blue-500">👤</span> {{ $usuariosActivos }} usuarios activos</li>
            </ul>
        </div>
    </div>

   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Actividades -->
    <div class="bg-gradient-to-tr from-gray-700 via-gray-800 to-gray-900 p-4 rounded-2xl shadow-xl border border-gray-800">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <i class="fas fa-list-check mr-2"></i>Últimas Actividades
        </h3>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-inner px-3 py-2 overflow-x-auto">
            <table class="min-w-full text-xs">
                <thead>
                <tr class="text-gray-700 dark:text-gray-200 border-b border-gray-300 dark:border-gray-800 font-semibold">
                    <th class="py-1 px-2 text-left">Título</th>
                    <th class="py-1 px-2 text-left">Autor</th>
                    <th class="py-1 px-2 text-left">Fecha</th>
                    <th class="py-1 px-2 text-left">Área</th>
                </tr>
                </thead>
                <tbody>
                @foreach($actividadesRecientes as $actividad)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-800/70">
                        <td class="py-1 px-2">{{ $actividad->titulo }}</td>
                        <td class="py-1 px-2">{{ $actividad->autor ?? 'Anónimo' }}</td>
                        <td class="py-1 px-2">{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                        <td class="py-1 px-2">
                            <span class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-100 rounded px-2 py-0.5 text-xs">
                                {{ $actividad->tipo_area ?? 'Sin área' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{ route('actividades.registradas') }}" class="text-sm font-semibold text-gray-600 hover:underline mt-2 block text-right">Ver todas</a>
        </div>
    </div>
    
    <!-- Usuarios -->
    <div class="bg-gradient-to-tr from-gray-700 via-gray-800 to-gray-900 p-4 rounded-2xl shadow-xl border border-gray-800">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <i class="fas fa-user-group mr-2"></i>Últimos Usuarios
        </h3>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-inner px-3 py-2 overflow-x-auto">
            <table class="min-w-full text-xs">
                <thead>
                <tr class="text-gray-700 dark:text-gray-200 border-b border-gray-300 dark:border-gray-800 font-semibold">
                    <th class="py-1 px-2 text-left">Nombre</th>
                    <th class="py-1 px-2 text-left">Email</th>
                    <th class="py-1 px-2 text-left">Registrado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($usuariosRecientes as $usuario)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-800/70">
                        <td class="py-1 px-2">{{ $usuario->name }}</td>
                        <td class="py-1 px-2">{{ $usuario->email }}</td>
                        <td class="py-1 px-2">{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                @if($usuariosRecientes->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-gray-500 py-2">Sin registros</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <a href="{{ route('usuarios.index') }}" class="text-sm font-semibold text-gray-600 hover:underline mt-2 block text-right">Ver todos</a>
        </div>
    </div>
</div>


    <!-- Reportes rápidos -->
    <div class="mt-6">
        <a href="{{ route('informes.stats') }}" class="btn btn-success">
            Exportar informes generales
        </a>
    </div>
</div>
@endsection
