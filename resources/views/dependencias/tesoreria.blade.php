@extends('layouts.master-public')

@section('title', 'Tesorería - Dependencias')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">
    
    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/tesoreria.png') }}" 
             alt="Logo Tesorería" 
             class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Dirección de Tesorería</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-3xl mx-auto">
            Encargada de la administración de los recursos financieros del municipio, 
            garantizando transparencia, eficiencia y correcto manejo del presupuesto público.
        </p>
    </div>

    <!-- Funciones principales -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Funciones principales</h2>
        <ul class="space-y-3 text-gray-700 text-base list-disc pl-6">
            <li>Recaudación de impuestos y contribuciones municipales.</li>
            <li>Administración de ingresos y egresos del municipio.</li>
            <li>Control y seguimiento del presupuesto municipal.</li>
            <li>Supervisión de pagos a proveedores y contratistas.</li>
            <li>Garantizar transparencia y cumplimiento de normas financieras.</li>
        </ul>
    </div>

    <!-- Proyectos destacados (opcional) -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Proyectos destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Proyecto 1 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/cobranza.jpg') }}" alt="Optimización de cobranza" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Optimización de cobranza</h3>
                    <p class="text-gray-600 text-sm">Mejoras en los procesos de recaudación de impuestos municipales.</p>
                </div>
            </div>
            <!-- Proyecto 2 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/presupuesto.jpg') }}" alt="Gestión del presupuesto" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Gestión del presupuesto</h3>
                    <p class="text-gray-600 text-sm">Control y planificación de los recursos municipales de manera eficiente.</p>
                </div>
            </div>
            <!-- Proyecto 3 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/proyectos/transparencia.jpg') }}" alt="Transparencia financiera" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800">Transparencia financiera</h3>
                    <p class="text-gray-600 text-sm">Implementación de medidas para garantizar la transparencia en el manejo de fondos.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <p><span class="font-bold">📍 Dirección:</span> Palacio Municipal, 1° piso, Oficina de Tesorería</p>
            <p><span class="font-bold">📞 Teléfono:</span> 747-456-7890</p>
            <p><span class="font-bold">✉️ Email:</span> tesoreria@municipio.gob.mx</p>
            <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
        </div>
    </div>

</div>
@endsection
