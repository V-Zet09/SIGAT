@extends('layouts.master-public')

@section('title', 'Salud - Dependencias')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">
    
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/salud.png') }}" 
             alt="Logo Salud" 
             class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Dirección de Salud</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-3xl mx-auto">
            Encargada de garantizar el bienestar de la población mediante la prevención de enfermedades, 
            promoción de la salud y atención médica eficiente en todo el municipio.
        </p>
    </div>

    <!-- Funciones principales -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Funciones principales</h2>
        <ul class="space-y-3 text-gray-700 text-base list-disc pl-6">
            <li>Promoción de campañas de prevención y cuidado de la salud.</li>
            <li>Supervisión de centros de salud y clínicas municipales.</li>
            <li>Coordinación de programas de vacunación y atención primaria.</li>
            <li>Gestión de recursos médicos y medicamentos.</li>
            <li>Fomentar la educación sanitaria y hábitos saludables en la comunidad.</li>
        </ul>
    </div>

    <!-- Proyectos destacados (opcional) -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Proyectos destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Proyecto 1 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/vacunacion.jpg') }}" alt="Campaña de vacunación" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Campaña de vacunación</h3>
                    <p class="text-gray-600 text-sm">Vacunación preventiva para niños, jóvenes y adultos del municipio.</p>
                </div>
            </div>
            <!-- Proyecto 2 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/clinica.jpg') }}" alt="Mejora de clínicas" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Mejora de clínicas</h3>
                    <p class="text-gray-600 text-sm">Renovación y equipamiento de centros de salud municipales.</p>
                </div>
            </div>
            <!-- Proyecto 3 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/salud_comunitaria.jpg') }}" alt="Programas de salud comunitaria" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Programas de salud comunitaria</h3>
                    <p class="text-gray-600 text-sm">Actividades y talleres de prevención y promoción de hábitos saludables.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <p><span class="font-bold">📍 Dirección:</span> Palacio Municipal, 1° piso, Oficina de Salud</p>
            <p><span class="font-bold">📞 Teléfono:</span> 747-345-6789</p>
            <p><span class="font-bold">✉️ Email:</span> salud@municipio.gob.mx</p>
            <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
        </div>
    </div>

</div>
@endsection
