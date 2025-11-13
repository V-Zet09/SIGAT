@extends('layouts.master')
@section('title', 'Acceso Denegado')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <i class="ri-error-warning-line text-8xl text-red-500"></i>
        </div>
        
        <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
            Acceso Denegado
        </h1>
        
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
            No tienes permiso para acceder a esta página.
        </p>
        
        <div class="space-y-3">
            <a href="javascript:history.back()" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                <i class="ri-arrow-left-line mr-2"></i>
                Volver atrás
            </a>
            
            <a href="{{ url('/') }}" 
               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition ml-3">
                <i class="ri-home-line mr-2"></i>
                Ir al inicio
            </a>
        </div>
        
        <div class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 rounded-lg">
            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                <i class="ri-information-line mr-1"></i>
                Si crees que deberías tener acceso, contacta al administrador del sistema.
            </p>
        </div>
    </div>
</div>
@endsection