@props(['nodo'])

<li class="relative mb-8 pl-6">
    @if(isset($nodo['hijos']))
        <span class="absolute top-0 left-3 w-0.5 h-full bg-gray-300"></span>
    @endif

    <div x-data="{ open: false }" class="bg-white rounded-2xl shadow-lg p-6 text-center w-64 mx-auto hover:shadow-2xl transition">
        <h2 class="text-xl font-bold text-gray-800">{{ $nodo['nombre'] }}</h2>
        <p class="text-gray-600">{{ $nodo['cargo'] }}</p>
        <p class="text-gray-500 text-sm mb-4">{{ $nodo['area'] }}</p>
        <button @click="open = !open" class="bg-[#00713D] text-white px-4 py-2 rounded-full hover:bg-[#005c30] transition shadow-sm">
            Ver contacto
        </button>

        <div x-show="open" x-transition class="mt-4 bg-[#A7D7C5] rounded-xl shadow-md p-6 text-left">
            <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $nodo['nombre'] }}</h3>
            <p class="text-gray-700 mb-1">{{ $nodo['cargo'] }}</p>
            <p class="text-gray-600 mb-4">{{ $nodo['area'] }}</p>
            <div class="flex gap-3 justify-end flex-wrap">
                <a href="mailto:{{ $nodo['email'] }}" class="bg-[#00713D] text-white px-4 py-2 rounded hover:bg-[#005c30] transition shadow-sm">
                    Enviar mensaje
                </a>
                <button @click="open = false" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition shadow-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    @if(isset($nodo['hijos']))
        <ul class="mt-6 flex justify-center gap-12">
            @foreach($nodo['hijos'] as $hijo)
                <x-nodo :nodo="$hijo" />
            @endforeach
        </ul>
    @endif
</li>
