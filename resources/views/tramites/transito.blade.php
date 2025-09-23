@extends('layouts.master-public')

@section('title', 'Trámites de Tránsito')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 md:px-8">

    <!-- Encabezado -->
    <div class="text-center mb-12">
        <img src="{{ asset('images/transito.png') }}" alt="Trámites de Tránsito" class="mx-auto w-28 h-28 object-contain mb-6 drop-shadow-md animate-bounce">
        <h1 class="text-3xl md:text-4xl font-bold text-[#00713D]">Trámites de Tránsito Municipal</h1>
        <p class="text-gray-600 mt-4 text-lg max-w-2xl mx-auto">
            Información sobre los trámites relacionados con tránsito y movilidad que se realizan en el Ayuntamiento. Aquí encontrarás requisitos, procedimientos y enlaces oficiales para realizar consultas y pagos de manera segura.
        </p>
    </div>

    <!-- Sección de Enlaces Oficiales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <!-- REPUVE -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://www.repuve.gob.mx/images/logo-repuve.png" alt="REPUVE" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Consulta REPUVE</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Verifica el estatus de tu vehículo y reporta vehículos robados.</p>
            <a href="https://www.repuve.gob.mx/repuve/login.jsp" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Consultar
            </a>
        </div>

        <!-- Licencias -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://smovilidad.edomex.gob.mx/images/logo-smovilidad.png" alt="Licencias" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Validación de Licencias</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Verifica tu licencia de conducir y constancias digitales.</p>
            <a href="https://smovilidad.edomex.gob.mx/validacion_de_licencias" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Validar
            </a>
        </div>

        <!-- Multas -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://www.gob.mx/cms/uploads/logo.png" alt="Pago Multas" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Pago de Multas</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Realiza el pago de infracciones en línea.</p>
            <a href="https://www.gob.mx/multas" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Pagar Multa
            </a>
        </div>

        <!-- Cita para Licencias -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://smovilidad.edomex.gob.mx/images/logo-smovilidad.png" alt="Cita Licencias" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Cita para Licencia</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Agendar cita presencial para trámite de licencias.</p>
            <a href="https://smovilidad.edomex.gob.mx/cita-licencia" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Agendar Cita
            </a>
        </div>

        <!-- Educación Vial -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="https://www.gob.mx/sct/images/logo-sct.png" alt="Educación Vial" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Educación Vial</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Programas de prevención de accidentes y seguridad vial.</p>
            <a href="https://www.gob.mx/sct/educacion-vial" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Consultar
            </a>
        </div>

        <!-- Consulta Infracciones Locales -->
        <div class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 transition transform hover:scale-105">
            <img src="{{ asset('images/tramites/infracciones.png') }}" alt="Infracciones Locales" class="w-16 h-16 mb-4 object-contain">
            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Consulta Infracciones</h3>
            <p class="text-gray-600 text-sm text-center mb-4">Verifica tus infracciones locales y realiza pagos.</p>
            <a href="https://www.municipio.gob.mx/transito/infracciones" target="_blank" class="mt-auto inline-block px-5 py-2 rounded-full bg-[#00713D] hover:bg-[#005f30] text-white font-semibold transition">
                Consultar
            </a>
        </div>
    </div>

    <!-- Contacto -->
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition">
        <h2 class="text-2xl font-semibold text-[#00713D] mb-6">📞 Contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">📍 Dirección:</span> Dirección de Tránsito, Palacio Municipal, 2° piso</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">📞 Teléfono:</span> 747-234-5678</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">✉️ Email:</span> transito@municipio.gob.mx</p>
            </div>
            <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                <p><span class="font-bold">🕘 Horario:</span> Lunes a Viernes, 9:00 AM - 3:00 PM</p>
            </div>
        </div>
    </div>

</div>
@endsection

