@extends('layouts.master-public')

@section('title', 'Obras Públicas - Dependencias')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">
    
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/obraspublicas.png') }}" 
             alt="Logo Obras Públicas" 
             class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Dirección de Obras Públicas</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-3xl mx-auto">
            Encargada de la planeación, construcción y mantenimiento de la infraestructura municipal, 
            buscando mejorar la calidad de vida de los ciudadanos.
        </p>
    </div>

    <!-- Funciones principales -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Funciones principales</h2>
        <ul class="space-y-3 text-gray-700 text-base list-disc pl-6">
            <li>Supervisión y ejecución de obras públicas municipales.</li>
            <li>Mantenimiento de calles, caminos y espacios públicos.</li>
            <li>Gestión de proyectos de infraestructura urbana y rural.</li>
            <li>Supervisión de contratistas y proveedores de obra.</li>
            <li>Garantizar el uso eficiente de los recursos destinados a infraestructura.</li>
        </ul>
    </div>

    <!-- Proyectos destacados (opcional) -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Proyectos destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Proyecto 1 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/calles.jpg') }}" alt="Rehabilitación de calles" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Rehabilitación de calles</h3>
                    <p class="text-gray-600 text-sm">Mejoramiento vial en colonias del municipio.</p>
                </div>
            </div>
            <!-- Proyecto 2 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/parque.jpg') }}" alt="Construcción de parque" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Construcción de parque</h3>
                    <p class="text-gray-600 text-sm">Nuevo espacio recreativo para familias.</p>
                </div>
            </div>
            <!-- Proyecto 3 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/puente.jpg') }}" alt="Puente peatonal" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Puente peatonal</h3>
                    <p class="text-gray-600 text-sm">Seguridad vial con pasos peatonales modernos.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <p><span class="font-bold">📍 Dirección:</span> Palacio Municipal, 2° piso, Oficina de Obras Públicas</p>
            <p><span class="font-bold">📞 Teléfono:</span> 747-123-4567</p>
            <p><span class="font-bold">✉️ Email:</span> obraspublicas@municipio.gob.mx</p>
            <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
        </div>
    </div>

</div>
@endsection
