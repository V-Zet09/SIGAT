@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.password-reset')
@endsection

@section('content')
<div class="relative h-screen flex items-start justify-center overflow-hidden">

    <!-- Imagen de fondo -->
    <img src="{{ asset('images/trampasdeluz.jpeg') }}" 
         alt="Fondo"
         class="absolute inset-0 w-full h-full object-cover">

    <!-- Capa oscura -->
    <div class="absolute inset-0 bg-black/50"></div>

    <!-- Tarjeta compacta -->
    <div class="relative w-full max-w-sm bg-white/30 backdrop-blur-md rounded-2xl shadow-xl p-6 z-10 border border-white/40 mt-20 md:mt-28">
        
        <!-- Imagen superior -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/carrusel2.jpeg') }}" 
                 alt="Decoración" 
                 class="w-20 h-20 rounded-full object-cover shadow-lg border-4 border-white/60">
        </div>

        <!-- Encabezado -->
        <div class="text-center mb-3">
            <h2 class="text-xl font-bold text-white">¿Olvidaste tu contraseña?</h2>
            <p class="text-gray-200 text-xs">
                Restablece tu acceso al sistema SIGAT
            </p>
        </div>

        <!-- Alerta -->
        <div class="bg-yellow-200/80 border-l-4 border-yellow-500 text-yellow-900 p-2 rounded mb-3 text-xs">
            <i class="fas fa-info-circle mr-1"></i> 
            Ingresa tu correo electrónico para recibir instrucciones.
        </div>

        <!-- Mensaje de éxito -->
        @if (session('status'))
            <div class="bg-green-200/80 border-l-4 border-green-600 text-green-900 p-2 rounded mb-3 text-xs text-center">
                <i class="fas fa-check-circle mr-1"></i> {{ session('status') }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-3">
            @csrf
            <div>
                <label for="email" class="block text-xs font-medium text-white">Correo electrónico</label>
                <input type="email" id="email" name="email" 
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-400 focus:border-blue-400 text-sm p-2
                       @error('email') border-red-500 @enderror"
                       placeholder="tu@correo.com" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-300 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-sm transition">
                <i class="fas fa-paper-plane mr-1"></i> Enviar enlace
            </button>
        </form>

        <!-- Enlace login -->
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-xs text-blue-200 hover:underline">
                <i class="fas fa-sign-in-alt mr-1"></i> ¿Ya recuerdas tu contraseña? Inicia sesión aquí
            </a>
        </div>

        <!-- Footer compacto -->
        <hr class="my-3 border-white/40">
        <footer class="text-center text-[10px] text-gray-200 leading-4">
            <p>
                &copy; <script>document.write(new Date().getFullYear())</script> <strong>SIGAT</strong><br>
                Desarrollado por Estudiantes de Educación Dual:<br>
                <strong>Maico Zaet</strong>, <strong>Mariana Lilibeth</strong>, 
                <strong>Jorge</strong>, <strong>José Ángel</strong><br>
                Carrera: <strong>Ingeniería Informática</strong><br>
                Contacto: 
                <a href="mailto:educaciondualsigat@gmail.com" class="hover:underline text-blue-300">educaciondualsigat@gmail.com</a>
            </p>
        </footer>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
@endsection
