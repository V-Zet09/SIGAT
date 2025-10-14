@extends('layouts.master-public')

@section('title', 'Educación - Dependencias')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">
    
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/educacion.png') }}" 
             alt="Logo Educación" 
             class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Dirección de Educación</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-3xl mx-auto">
            Fomenta la educación de calidad en todos los niveles, impulsando programas, capacitaciones
            y actividades que fortalecen el aprendizaje y el desarrollo de la comunidad.
        </p>
    </div>

    <!-- Funciones principales -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Funciones principales</h2>
        <ul class="space-y-3 text-gray-700 text-base list-disc pl-6">
            <li>Coordinar programas educativos en escuelas y comunidades del municipio.</li>
            <li>Capacitar y apoyar a docentes y personal educativo.</li>
            <li>Impulsar proyectos de mejora en infraestructura educativa.</li>
            <li>Promover actividades extracurriculares y culturales en escuelas.</li>
            <li>Garantizar acceso a educación inclusiva y de calidad para todos los ciudadanos.</li>
        </ul>
    </div>

    <!-- Proyectos destacados (opcional) -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Proyectos destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Proyecto 1 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/aulas.jpg') }}" alt="Mejora de aulas" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Mejora de aulas</h3>
                    <p class="text-gray-600 text-sm">Renovación de aulas y mobiliario en escuelas municipales.</p>
                </div>
            </div>
            <!-- Proyecto 2 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/talleres_educativos.jpg') }}" alt="Talleres educativos" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Talleres educativos</h3>
                    <p class="text-gray-600 text-sm">Programas de capacitación y actividades para estudiantes y docentes.</p>
                </div>
            </div>
            <!-- Proyecto 3 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/becas.jpg') }}" alt="Becas y apoyos" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Becas y apoyos</h3>
                    <p class="text-gray-600 text-sm">Programas de becas y ayudas para fomentar la continuidad educativa.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <p><span class="font-bold">📍 Dirección:</span> Palacio Municipal, 2° piso, Oficina de Educación</p>
            <p><span class="font-bold">📞 Teléfono:</span> 747-234-5678</p>
            <p><span class="font-bold">✉️ Email:</span> educacion@municipio.gob.mx</p>
            <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
        </div>
    </div>

</div>
@endsection
