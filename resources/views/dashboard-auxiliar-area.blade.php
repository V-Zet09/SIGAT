@extends('layouts.master')
@section('title')
    Auxiliar de Area
@endsection
@section('css')
    <!--Swiper slider css-->
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- jsvectormap css -->
    <link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            BIENVENIDO AUXILIAR 
        @endslot
    @endcomponent

<div class="p-6 space-y-6">

    <!-- Actividades Registradas -->
    <div class="bg-green-50 dark:bg-gray-800 border border-green-300 dark:border-gray-700 rounded-xl shadow-lg hover:shadow-xl transition">
        <div class="bg-green-600 dark:bg-green-700 text-white text-center py-3 rounded-t-xl font-semibold text-lg">
             Actividades Registradas 📌
        </div>
        <ul class="divide-y divide-green-200 dark:divide-gray-700">
            <li class="flex justify-between items-center py-3 px-5">
                Actividad registrada 1
                <button class="px-4 py-1 text-sm rounded-full border border-green-600 text-green-600 dark:text-green-300 hover:bg-green-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
            <li class="flex justify-between items-center py-3 px-5">
                Actividad registrada 2
                <button class="px-4 py-1 text-sm rounded-full border border-green-600 text-green-600 dark:text-green-300 hover:bg-green-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
            <li class="flex justify-between items-center py-3 px-5">
                Actividad registrada 3
                <button class="px-4 py-1 text-sm rounded-full border border-green-600 text-green-600 dark:text-green-300 hover:bg-green-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
        </ul>
    </div>

    <!-- Actividades en Revisión -->
    <div class="bg-yellow-50 dark:bg-gray-800 border border-yellow-300 dark:border-gray-700 rounded-xl shadow-lg hover:shadow-xl transition">
        <div class="bg-yellow-600 dark:bg-yellow-700 text-white text-center py-3 rounded-t-xl font-semibold text-lg">
             Actividades en Revisión 🔍
        </div>
        <ul class="divide-y divide-yellow-200 dark:divide-gray-700">
            <li class="flex justify-between items-center py-3 px-5">
                Actividad en revisión 1
                <button class="px-4 py-1 text-sm rounded-full border border-yellow-600 text-yellow-600 dark:text-yellow-300 hover:bg-yellow-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
            <li class="flex justify-between items-center py-3 px-5">
                Actividad en revisión 2
                <button class="px-4 py-1 text-sm rounded-full border border-yellow-600 text-yellow-600 dark:text-yellow-300 hover:bg-yellow-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
            <li class="flex justify-between items-center py-3 px-5">
                Actividad en revisión 3
                <button class="px-4 py-1 text-sm rounded-full border border-yellow-600 text-yellow-600 dark:text-yellow-300 hover:bg-yellow-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
        </ul>
    </div>

    <!-- Actividades Aprobadas -->
    <div class="bg-blue-50 dark:bg-gray-800 border border-blue-300 dark:border-gray-700 rounded-xl shadow-lg hover:shadow-xl transition">
        <div class="bg-blue-600 dark:bg-blue-700 text-white text-center py-3 rounded-t-xl font-semibold text-lg">
             Actividades Aprobadas ✅
        </div>
        <ul class="divide-y divide-blue-200 dark:divide-gray-700">
            <li class="flex justify-between items-center py-3 px-5">
                Actividad aprobada 1
                <button class="px-4 py-1 text-sm rounded-full border border-blue-600 text-blue-600 dark:text-blue-300 hover:bg-blue-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
            <li class="flex justify-between items-center py-3 px-5">
                Actividad aprobada 2
                <button class="px-4 py-1 text-sm rounded-full border border-blue-600 text-blue-600 dark:text-blue-300 hover:bg-blue-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
            <li class="flex justify-between items-center py-3 px-5">
                Actividad aprobada 3
                <button class="px-4 py-1 text-sm rounded-full border border-blue-600 text-blue-600 dark:text-blue-300 hover:bg-blue-600 hover:text-white transition">
                    Ver detalles
                </button>
            </li>
        </ul>
    </div>

</div>
@endsection