@extends('layouts.master-without-nav')

@section('title', 'Nueva Contraseña')

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
                    <i class="ri-key-2-line text-5xl text-green-600"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Crear Nueva Contraseña</h1>
                <p class="text-green-100 text-sm">Elige una contraseña segura y fácil de recordar</p>
            </div>

            <div class="p-8">
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded">
                    <div class="flex items-start">
                        <i class="ri-lightbulb-line text-2xl text-yellow-600 mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-yellow-900 font-semibold mb-1">Consejos para tu contraseña:</p>
                            <ul class="text-yellow-800 text-sm space-y-1">
                                <li>✓ Mínimo 8 caracteres</li>
                                <li>✓ Usa letras y números</li>
                                <li>✓ Evita palabras comunes</li>
                                <li>✓ No uses tu fecha de nacimiento</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 text-lg">
                            <i class="ri-mail-line mr-2"></i>Tu correo
                        </label>
                        <div class="px-4 py-4 bg-gray-100 text-gray-700 rounded-xl text-lg font-medium border-2 border-gray-200">
                            {{ $email ?? old('email') }}
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 font-semibold mb-2 text-lg">
                            <i class="ri-lock-line mr-2"></i>Nueva contraseña
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-green-200 focus:border-green-500 transition pr-12 @error('password') border-red-500 @enderror"
                                placeholder="Escribe tu nueva contraseña"
                                required>
                            <button
                                type="button"
                                onclick="togglePassword('password')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="ri-eye-line text-xl" id="eye-password"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="mt-2 flex items-center text-red-600">
                                <i class="ri-error-warning-line mr-2"></i>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2 text-lg">
                            <i class="ri-lock-2-line mr-2"></i>Confirmar contraseña
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-green-200 focus:border-green-500 transition pr-12"
                                placeholder="Escribe nuevamente tu contraseña"
                                required>
                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="ri-eye-line text-xl" id="eye-password_confirmation"></i>
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-5 text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 mt-6">
                        <i class="ri-check-line text-xl"></i>
                        <span>Guardar nueva contraseña</span>
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

<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animation-delay-4000 {
    animation-delay: 4s;
}
</style>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById('eye-' + inputId);

    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.remove('ri-eye-line');
        eye.classList.add('ri-eye-off-line');
    } else {
        input.type = 'password';
        eye.classList.remove('ri-eye-off-line');
        eye.classList.add('ri-eye-line');
    }
}
</script>
@endsection

@section('script')
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
@endsection
