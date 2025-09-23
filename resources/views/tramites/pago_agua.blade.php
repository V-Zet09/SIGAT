@extends('layouts.master-public')

@section('title', 'Trámite: Pago de Agua')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">

    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/agua.png') }}" 
             alt="Pago de Agua" 
             class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md animate-bounce">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Trámite: Pago de Agua Potable</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-2xl mx-auto">
            El pago del servicio de agua potable <strong>se realiza de manera presencial</strong> en el Ayuntamiento.  
            Aquí encontrarás los requisitos, pasos y datos de contacto para llevar a cabo tu trámite.
        </p>
    </div>

    <!-- Aviso Importante -->
    <div class="mb-10">
        <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50" role="alert">
            <svg class="flex-shrink-0 w-5 h-5 me-2 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9 4.5a1 1 0 1 1 2 0v6a1 1 0 0 1-2 0v-6Zm1 12a1.25 1.25 0 1 1 1.25-1.25A1.25 1.25 0 0 1 10 16.5Z"/>
            </svg>
            <span class="font-medium">Importante:</span>&nbsp; Este trámite <u>no se puede realizar en línea</u>. Debes acudir a la Tesorería Municipal.
        </div>
    </div>

    <!-- Requisitos -->
    <div class="bg-white shadow-lg rounded-2xl p-8 mb-10 border border-gray-100 hover:shadow-2xl transition">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">📋 Requisitos</h2>
        <ul class="space-y-3 text-gray-700 text-base list-disc pl-6">
            <li>Recibo anterior de agua (si cuentas con él).</li>
            <li>Clave Catastral o número de contrato del servicio.</li>
            <li>Identificación oficial vigente (INE, pasaporte o licencia).</li>
            <li>Monto correspondiente al pago en efectivo o tarjeta bancaria.</li>
        </ul>

        <!-- Botón CTA -->
        <div class="mt-6">
            <a href="{{ asset('docs/requisitos-pago-agua.pdf') }}" target="_blank"
               class="inline-flex items-center px-6 py-3 text-white bg-[#00713D] hover:bg-[#005C2F] font-medium rounded-lg text-sm shadow-md transition">
                📑 Descargar requisitos en PDF
            </a>
        </div>
    </div>

    <!-- Pasos del Trámite - Timeline Flowbite -->
    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">📝 Pasos para realizar el trámite</h2>

        <ol class="relative border-s border-gray-200">                  
            <li class="mb-10 ms-6">            
                <span class="absolute flex items-center justify-center w-8 h-8 bg-[#00713D] rounded-full -start-4 ring-4 ring-white">
                    1
                </span>
                <h3 class="font-semibold text-gray-900">Acude a la Tesorería Municipal</h3>
                <p class="text-gray-600">Ubicada en el Palacio Municipal, planta baja.</p>
            </li>
            <li class="mb-10 ms-6">            
                <span class="absolute flex items-center justify-center w-8 h-8 bg-[#00713D] rounded-full -start-4 ring-4 ring-white">
                    2
                </span>
                <h3 class="font-semibold text-gray-900">Presenta tu recibo y tu identificación</h3>
                <p class="text-gray-600">Entrega tus documentos en ventanilla.</p>
            </li>
            <li class="mb-10 ms-6">            
                <span class="absolute flex items-center justify-center w-8 h-8 bg-[#00713D] rounded-full -start-4 ring-4 ring-white">
                    3
                </span>
                <h3 class="font-semibold text-gray-900">Indica tu número de contrato</h3>
                <p class="text-gray-600">El personal validará tu información en el sistema.</p>
            </li>
            <li class="mb-10 ms-6">            
                <span class="absolute flex items-center justify-center w-8 h-8 bg-[#00713D] rounded-full -start-4 ring-4 ring-white">
                    4
                </span>
                <h3 class="font-semibold text-gray-900">Realiza el pago</h3>
                <p class="text-gray-600">En caja con efectivo o tarjeta bancaria.</p>
            </li>
            <li class="ms-6">            
                <span class="absolute flex items-center justify-center w-8 h-8 bg-[#00713D] rounded-full -start-4 ring-4 ring-white">
                    5
                </span>
                <h3 class="font-semibold text-gray-900">Recibe tu comprobante</h3>
                <p class="text-gray-600">Constancia sellada de tu pago.</p>
            </li>
        </ol>
    </div>

    <!-- Horarios y Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">📞 Horario y Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">📍 Dirección:</span> Tesorería Municipal, Palacio de Gobierno, Planta Baja</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">📞 Teléfono:</span> 747-123-4567 (Ext. Agua Potable)</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">✉️ Email:</span> tesoreria.agua@municipio.gob.mx</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
            </div>
        </div>
    </div>

</div>
@endsection
