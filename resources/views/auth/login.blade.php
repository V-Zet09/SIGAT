@extends('layouts.master-public')

@section('title', 'SIGAT')

@section('content')
<div class="flex flex-col w-full py-10 px-4 md:px-20 flex-1">
    
    <!-- Sección superior: Carrusel + Login -->
    <div class="container mx-auto px-4 md:px-8 flex flex-col md:flex-row items-center justify-center gap-6 md:gap-10">
        
     <!-- Columna izquierda: Carrusel -->
<div class="flex flex-col md:flex md:w-1/2 lg:w-5/12 min-w-[320px] flex-shrink-0 items-center justify-center">
    <div class="relative w-full max-w-lg h-auto aspect-[4/3] bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div id="default-carousel" class="relative w-full h-full" data-carousel="slide" data-carousel-interval="5000">
            <div class="relative w-full h-full overflow-hidden rounded-2xl">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="hidden duration-700 ease-in-out {{ $i == 1 ? 'block' : '' }}" 
                         data-carousel-item="{{ $i == 1 ? 'active' : '' }}">
                        <img src="{{ asset("images/carrusel$i.jpeg") }}" 
                             class="block w-full h-full object-cover" 
                             alt="Carrusel {{ $i }}">
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>


        <!-- Columna derecha: Login -->
       <div class="flex md:w-1/2 lg:w-5/12 min-w-[300px] items-center justify-center mt-10 md:mt-0">
            <div class="relative w-full max-w-md">
                <div class="absolute -top-3 -left-3 w-full h-full bg-green-700/95 backdrop-blur-md rounded-2xl rotate-3"></div>
                <div class="relative w-full p-8 bg-white rounded-2xl shadow-lg flex flex-col">
                    
                    <!-- Encabezado -->
                    <div class="mb-6 text-center">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Bienvenido</h1>
                        <p class="text-sm md:text-base text-gray-500">
                            Inicia sesión para acceder a
                            <span class="font-semibold text-green-700">SIGAT</span>
                        </p>
                    </div>

                    <!-- Formulario -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-5 flex-1 text-sm md:text-base">
                        @csrf
                        
                        <!-- Usuario -->
                        <div>
                            <label for="username" class="block mb-1 font-medium text-gray-700">
                                Usuario <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="email" id="username" value="{{ old('email') }}"
                                   class="bg-gray-100 border border-gray-300 text-gray-800 rounded-lg shadow-sm
                                          focus:ring-green-600 focus:border-green-600 block w-full p-2.5"
                                   placeholder="tu@correo.com" required>
                        </div>

                        <!-- Contraseña -->
                        <div>
                            <div class="flex justify-between items-center">
                                <label for="password-input" class="block mb-1 font-medium text-gray-700">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <a href="{{ route('password.update') }}" class="text-green-600 hover:underline text-xs">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                            <div class="relative">
                                <input type="password" name="password" id="password-input"
                                       class="bg-gray-100 border border-gray-300 text-gray-800 rounded-lg shadow-sm
                                              focus:ring-green-600 focus:border-green-600 block w-full p-2.5 pr-10"
                                       placeholder="••••••••" required>
                                <button type="button" id="toggle-password"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <i class="ri-eye-fill" id="toggle-icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Recordarme -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center text-gray-600">
                                <input id="auth-remember-check" type="checkbox"
                                       class="w-4 h-4 border-gray-400 rounded bg-gray-100 text-green-700 focus:ring-green-600">
                                <span class="ml-2">Recuérdame</span>
                            </label>
                        </div>

                        <!-- Botones -->
                        <div>
                            <button id="btn-login" type="submit"
                                    class="w-full text-white bg-green-700/95 hover:bg-green-800 focus:ring-4
                                           focus:outline-none focus:ring-green-600 font-medium rounded-lg px-5 py-2.5 transition-all shadow-md hover:shadow-lg">
                                Iniciar sesión
                            </button>

                            <button id="btn-loading" disabled type="button"
                                    class="hidden w-full text-white bg-green-700/95 focus:ring-4 focus:outline-none
                                           focus:ring-green-600 font-medium rounded-lg px-5 py-2.5 inline-flex items-center justify-center rounded-lg">
                                <svg aria-hidden="true" role="status"
                                     class="inline w-4 h-4 me-3 text-white animate-spin"
                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858
                                        100.591 0 78.2051 0 50.5908C0 22.9766 22.3858
                                        0.59082 50 0.59082C77.6142 0.59082
                                        100 22.9766 100 50.5908ZM9.08144
                                        50.5908C9.08144 73.1895 27.4013
                                        91.5094 50 91.5094C72.5987
                                        91.5094 90.9186 73.1895 90.9186
                                        50.5908C90.9186 27.9921 72.5987
                                        9.67226 50 9.67226C27.4013
                                        9.67226 9.08144 27.9921
                                        9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393
                                        38.4038 97.8624 35.9116 97.0079
                                        33.5539C95.2932 28.8227 92.871
                                        24.3692 89.8167 20.348C85.8452
                                        15.1192 80.8826 10.7238 75.2124
                                        7.41289C69.5422 4.10194 63.2754
                                        1.94025 56.7698 1.05124C51.7666
                                        0.367541 46.6976 0.446843
                                        41.7345 1.27873C39.2613 1.69328
                                        37.813 4.19778 38.4501
                                        6.62326C39.0873 9.04874 41.5694
                                        10.4717 44.0505 10.1071C47.8511
                                        9.54855 51.7191 9.52689 55.5402
                                        10.0491C60.8642 10.7766 65.9928
                                        12.5457 70.6331 15.2552C75.2735
                                        17.9648 79.3347 21.5619 82.5849
                                        25.841C84.9175 28.9121 86.7997
                                        32.2913 88.1811 35.8758C89.083
                                        38.2158 91.5421 39.6781 93.9676
                                        39.0409Z" fill="currentColor"/>
                                </svg>
                                Cargando...
                            </button>
                        </div>

                        <!-- Mini-footer dentro de la tarjeta -->
                        <footer class="mt-6 text-center text-xs text-gray-400 border-t pt-4">
                            <p class="mb-0 text-muted small">
                            &copy; <script>document.write(new Date().getFullYear())</script> <strong>SIGAT</strong><br>
                            Desarrollado por Estudiantes de Educación Dual:<br>
                            <strong>Maico Zaet</strong>, <strong>Mariana Lilibeth</strong>, <strong>Jorge</strong>, <strong>José Ángel</strong><br>
                            Carrera: <strong>Ingeniería Informática</strong><br>
                            Contacto: <a href="mailto:educaciondualsigat@gmail.com">educaciondualsigat@gmail.com</a>
                            </p>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggle-password");
    const passwordInput = document.getElementById("password-input");
    const icon = document.getElementById("toggle-icon");

    toggleBtn.addEventListener("click", () => {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.replace("ri-eye-fill", "ri-eye-off-fill");
        } else {
            passwordInput.type = "password";
            icon.classList.replace("ri-eye-off-fill", "ri-eye-fill");
        }
    });

    const loginForm = document.querySelector("form");
    const btnLogin = document.getElementById("btn-login");
    const btnLoading = document.getElementById("btn-loading");

    loginForm.addEventListener("submit", () => {
        btnLogin.classList.add("hidden");
        btnLoading.classList.remove("hidden");
    });
});
</script>
@endsection
