@extends('layouts.master-public')

@section('title', 'Gobierno Municipal')

@section('css')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .card-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .presidente-card:hover .presidente-badge {
        animation: float 2s ease-in-out infinite;
    }
    
    .gradient-border {
        position: relative;
        background: linear-gradient(white, white) padding-box,
                    linear-gradient(135deg, #10b981, #3b82f6, #8b5cf6) border-box;
        border: 3px solid transparent;
    }
    
    .dark .gradient-border {
        background: linear-gradient(#1f2937, #1f2937) padding-box,
                    linear-gradient(135deg, #10b981, #3b82f6, #8b5cf6) border-box;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Principal --}}
        <div class="text-center mb-12 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg mb-4">
                <i class="ri-government-line text-4xl text-white"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 mb-3">
                Gobierno Municipal de Tlapehuala
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 font-medium">Periodo 2024 - 2027</p>
            <div class="mt-4 flex items-center justify-center gap-2">
                <span class="h-1 w-12 bg-gradient-to-r from-green-500 to-transparent rounded-full"></span>
                <i class="ri-sparkling-line text-2xl text-green-500"></i>
                <span class="h-1 w-12 bg-gradient-to-l from-green-500 to-transparent rounded-full"></span>
            </div>
        </div>

        {{-- Presidente Municipal --}}
        <div class="mb-16 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 inline-flex items-center gap-3">
                    <i class="ri-user-star-line text-green-600"></i>
                    Presidente Municipal
                </h2>
            </div>
            
            <div class="presidente-card card-hover gradient-border rounded-3xl overflow-hidden bg-white dark:bg-gray-800 shadow-2xl">
                <div class="grid md:grid-cols-2 gap-8 p-8">
                    {{-- Imagen --}}
                    <div class="relative">
                        <div class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-400 to-blue-500 rounded-full opacity-20 blur-2xl"></div>
                        <div class="relative aspect-square rounded-2xl overflow-hidden shadow-2xl border-4 border-white dark:border-gray-700">
                            <img src="{{ asset('resources/images/presi.jpg') }}" 
                                 alt="Presidente Municipal" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>
                        {{-- Badge flotante --}}
                        <div class="presidente-badge absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-full shadow-xl">
                            <i class="ri-shield-star-line mr-2"></i>
                            <span class="font-bold">Presidente</span>
                        </div>
                    </div>
                    
                    {{-- Información --}}
                    <div class="flex flex-col justify-center space-y-6">
                        <div>
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400 mb-2 uppercase tracking-wider">
                                Presidente Municipal Constitucional
                            </p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                                C. José Luis Antúnez Goicochea
                            </h3>
                        </div>
                        
                        <div class="space-y-4">
                            {{-- Contacto --}}
                            <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="ri-phone-line text-2xl text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Teléfono de Contacto</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">7328980098</p>
                                </div>
                            </div>
                            
                            {{-- Facebook --}}
                            <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="ri-facebook-circle-line text-2xl text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Facebook Oficial</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">José Luis Antúnez Goicochea</p>
                                </div>
                            </div>
                            
                            {{-- Dirección --}}
                            <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="ri-map-pin-line text-2xl text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dirección</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">Palacio Municipal, Tlapehuala</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cabildo Municipal --}}
        <div class="animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 inline-flex items-center gap-3 mb-2">
                    <i class="ri-team-line text-blue-600"></i>
                    Cabildo Municipal
                </h2>
                <p class="text-gray-600 dark:text-gray-400">Honorable Ayuntamiento Constitucional</p>
            </div>

            {{-- Foto Grupal del Cabildo --}}
            <div class="mb-8 card-hover">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('images/cabildo-municipal.jpg') }}" 
                         alt="Cabildo Municipal" 
                         class="w-full h-auto object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">Honorable Cabildo Municipal 2024-2027</h3>
                        <p class="text-gray-200">Trabajando juntos por Tlapehuala</p>
                    </div>
                </div>
            </div>

            {{-- Síndica --}}
            <div class="mb-8">
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0 w-24 h-24 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            MC
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 text-xs font-bold rounded-full mb-2">
                                SÍNDICA PROCURADORA
                            </span>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Profa. Maricela Cruz Cedillo
                            </h3>
                        </div>
                        <div class="hidden md:block">
                            <i class="ri-scales-line text-5xl text-pink-200 dark:text-pink-800"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Regidores Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                {{-- Regidor 1 --}}
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border-l-4 border-blue-500">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            ZH
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded mb-2">
                                REGIDOR
                            </span>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">
                                C. Zenón Huerta Arellano
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                <i class="ri-building-line text-blue-500 mt-1"></i>
                                <span>Desarrollo Urbano, Medio Ambiente y Obras Públicas</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Regidor 2 --}}
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border-l-4 border-purple-500">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            MB
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 text-xs font-semibold rounded mb-2">
                                REGIDORA
                            </span>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">
                                C. Ma. del Carmen Barrera Galarza
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                <i class="ri-book-open-line text-purple-500 mt-1"></i>
                                <span>Educación, Cultura, Recreación y Juventud</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Regidor 3 --}}
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border-l-4 border-green-500">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            AL
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 text-xs font-semibold rounded mb-2">
                                REGIDOR
                            </span>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">
                                C. Arturo León Juan
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                <i class="ri-heart-pulse-line text-green-500 mt-1"></i>
                                <span>Salud y Asistencia Social</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Regidor 4 --}}
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border-l-4 border-pink-500">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            IQ
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 text-xs font-semibold rounded mb-2">
                                REGIDORA
                            </span>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">
                                C. Ma. Isabel Quintana Gómez
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                <i class="ri-women-line text-pink-500 mt-1"></i>
                                <span>Equidad y Género, Derecho de las Niñas y Adolescentes</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Regidor 5 --}}
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border-l-4 border-yellow-500">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            JC
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 text-xs font-semibold rounded mb-2">
                                REGIDOR
                            </span>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">
                                C. Jesús Javier Cruz
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                <i class="ri-plant-line text-yellow-500 mt-1"></i>
                                <span>Desarrollo Rural, Participación Social de Migrantes</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Regidor 6 --}}
                <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl border-l-4 border-indigo-500">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            EA
                        </div>
                        <div class="flex-1">
                            <span class="inline-block px-2 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 text-xs font-semibold rounded mb-2">
                                REGIDORA
                            </span>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">
                                C. Edith Aguirre Flores
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                <i class="ri-store-line text-indigo-500 mt-1"></i>
                                <span>Comercio, Abasto Popular y Fomento al Empleo</span>
                            </p>
                        </div>
                    </div>
                </div>
                        <div class="flex-1">

                        </div>
                    </div>
                </div>

                
            {{-- Secretario General --}}
            <div class="card-hover bg-gradient-to-r from-gray-800 to-gray-900 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 shadow-2xl text-white">
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0 w-24 h-24 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        ML
                    </div>
                    <div class="flex-1">
                        <span class="inline-block px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full mb-2">
                            SECRETARIO GENERAL
                        </span>
                        <h3 class="text-2xl font-bold mb-1">
                            C. Profr. Mario Alberto Lagunas Salgado
                        </h3>
                        <p class="text-gray-300">Secretario General del H. Ayuntamiento Municipal Constitucional</p>
                    </div>
                    <div class="hidden md:block">
                        <i class="ri-file-text-line text-5xl text-white/20"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection