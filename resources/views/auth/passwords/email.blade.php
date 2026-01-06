@extends('layouts.master-without-nav')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="relative min-h-screen flex items-center justify-center p-4 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700"></div>

    <div class="absolute top-20 left-20 w-72 h-72 bg-white/20 rounded-full blur-3xl animate-blob"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-emerald-300/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-20 left-40 w-72 h-72 bg-teal-300/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>

    <div class="relative w-full max-w-md z-10">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 p-8 text-center">
                <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="ri-lock-password-line text-5xl text-green-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">¿Olvidaste tu contraseña?</h1>
                <p class="text-green-100 text-sm">No te preocupes, es fácil recuperarla</p>
            </div>

            <div class="p-8">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                    <div class="flex items-start">
                        <i class="ri-information-line text-2xl text-blue-600 mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-blue-900 font-semibold mb-1">Sigue estos pasos:</p>
                            <ol class="text-blue-800 text-sm space-y-1 list-decimal list-inside">
                                <li>Escribe tu correo electrónico</li>
                                <li>Haz clic en "Enviar"</li>
                                <li>Revisa tu correo (bandeja de entrada)</li>
                                <li>Haz clic en el enlace que te enviamos</li>
                            </ol>
                        </div>
                    </div>
                </div>

                @if (session('status'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded animate-fade-in">
                        <div class="flex items-center">
                            <i class="ri-check-circle-line text-2xl text-green-600 mr-3"></i>
                            <div>
                                <p class="text-green-900 font-semibold">¡Correo enviado!</p>
                                <p class="text-green-700 text-sm">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-gray-700 font-semibold mb-2 text-lg">
                            <i class="ri-mail-line mr-2"></i>Tu correo electrónico
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-green-200 focus:border-green-500 transition @error('email') border-red-500 @enderror"
                            placeholder="ejemplo@correo.com"
                            required
                            autofocus>

                        @error('email')
                            <div class="mt-2 flex items-center text-red-600">
                                <i class="ri-error-warning-line mr-2"></i>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-5 text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="ri-send-plane-fill text-xl"></i>
                        <span>Enviar enlace de recuperación</span>
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center text-gray-600 hover:text-green-600 font-medium transition">
                        <i class="ri-arrow-left-line mr-2"></i>
                        Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-6 text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} SIGAT - Sistema de Gestión del Ayuntamiento</p>
            <p class="mt-1">
                ¿Necesitas ayuda? Llama al:
                <a href="tel:+524771234567" class="text-green-400 hover:text-green-300 font-semibold">477 123 4567</a>
            </p>
        </div>
    </div>
</div>
@endsection

@section('script')
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
@endsection
