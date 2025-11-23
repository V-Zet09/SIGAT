@extends('layouts.master')

@section('title', 'Ver Usuario')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                <i class="fas fa-user text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800"> Información del Usuario</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Nombre</p>
                <p class="text-lg text-gray-800 mt-1">{{ $usuario->name }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Sexo</p>
                <p class="text-lg text-gray-800 mt-1">{{ $usuario->sexo }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Cargo</p>
                <p class="text-lg text-gray-800 mt-1">{{ $usuario->cargo }}</p>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Área</p>
                <p class="text-lg text-gray-800 mt-1">{{ $usuario->area }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-sm font-semibold text-gray-500 uppercase">Correo electrónico</p>
                <p class="text-lg text-gray-800 mt-1">{{ $usuario->email }}</p>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('usuarios.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                ← Volver
            </a>
        </div>
    </div>
</div>
@endsection

