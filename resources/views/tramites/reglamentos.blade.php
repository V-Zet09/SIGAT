@extends('layouts.master-public')

@section('title', 'Reglamentos del Ayuntamiento')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">

    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/reglamentos.png') }}" alt="Reglamentos del Ayuntamiento" class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md animate-bounce">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Reglamentos del Ayuntamiento Municipal</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-2xl mx-auto">
            Conoce las normas y disposiciones que rigen el funcionamiento del Ayuntamiento y el comportamiento esperado de sus servidores públicos.
        </p>
    </div>

    <!-- Sección de Reglamentos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <!-- Reglamento de Vestimenta -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://www.tijuana.gob.mx/images/logo.png" alt="Reglamento de Vestimenta" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Reglamento de Vestimenta</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Normas sobre la vestimenta adecuada para el personal administrativo y operativo del Ayuntamiento.</p>
            <a href="{{ asset('docs/reglamento_vestimenta.pdf') }}" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Descargar PDF
            </a>
        </div>

        <!-- Reglamento Interior del Ayuntamiento -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://www.tijuana.gob.mx/images/logo.png" alt="Reglamento Interior" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Reglamento Interior del Ayuntamiento</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Disposiciones que regulan la organización y funcionamiento del Ayuntamiento.</p>
            <a href="{{ asset('docs/reglamento_interior.pdf') }}" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Descargar PDF
            </a>
        </div>

        <!-- Reglamento de Tránsito Municipal -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://www.tijuana.gob.mx/images/logo.png" alt="Reglamento de Tránsito" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Reglamento de Tránsito Municipal</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Normas que regulan la circulación vial y el comportamiento de conductores y peatones.</p>
            <a href="{{ asset('docs/reglamento_transito.pdf') }}" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Descargar PDF
            </a>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">📞 Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">📍 Dirección:</span> Dirección General de Reglamentos, Palacio Municipal, 2° piso</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">📞 Teléfono:</span> 747-234-5678</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">✉️ Email:</span> reglamentos@municipio.gob.mx</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
            </div>
        </div>
    </div>

</div>
@endsection
