@extends('layouts.master-public')

@section('title', 'Cultura - Dependencias')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">
    
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/cultura.png') }}" 
             alt="Logo Cultura" 
             class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Dirección de Cultura</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-3xl mx-auto">
            Promueve, preserva y difunde las expresiones culturales del municipio, fomentando la participación ciudadana y fortaleciendo la identidad local. Dirección a cargo del Lic. Anastacio Martínez Sánchez.
        </p>
    </div>

    <!-- Funciones principales -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Funciones principales</h2>
        <ul class="space-y-3 text-gray-700 text-base list-disc pl-6">
            <li>Organización de eventos culturales y festivales municipales.</li>
            <li>Promoción de las artes, música, danza y teatro locales.</li>
            <li>Preservación del patrimonio histórico y artístico del municipio.</li>
            <li>Apoyo a artistas y colectivos culturales locales.</li>
            <li>Fomentar la educación y participación cultural de la ciudadanía.</li>
        </ul>
    </div>

    <!-- Proyectos destacados (opcional) -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Proyectos destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Proyecto 1 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/festival.jpg') }}" alt="Festival Cultural" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Festival Cultural</h3>
                    <p class="text-gray-600 text-sm">Evento anual que celebra la música, danza y tradiciones locales.</p>
                </div>
            </div>
            <!-- Proyecto 2 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/museo.jpg') }}" alt="Museo Municipal" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Museo Municipal</h3>
                    <p class="text-gray-600 text-sm">Exposición permanente de arte y patrimonio histórico del municipio.</p>
                </div>
            </div>
            <!-- Proyecto 3 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/talleres.jpg') }}" alt="Talleres artísticos" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Talleres artísticos</h3>
                    <p class="text-gray-600 text-sm">Capacitaciones y talleres para fomentar la creatividad en la comunidad.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <p><span class="font-bold">📍 Dirección:</span> Palacio Municipal, 2° piso, Oficina de Cultura</p>
            <p><span class="font-bold">📞 Teléfono:</span> 747-765-4321</p>
            <p><span class="font-bold">✉️ Email:</span> cultura@tlapehuala2427.gob.mx</p>
            <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
        </div>
    </div>

</div>
@endsection
