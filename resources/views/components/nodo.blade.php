@props(['nodo'])

<li class="relative list-none flex flex-col items-center">

    <!-- FOTO Y TARJETA -->
    <div 
        x-data="{ open: false }"
        class="flex flex-col items-center mb-8 group"
    >
        <!-- FOTO -->
        <div 
            @click="open = true" 
            class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#00713D] cursor-pointer shadow-lg transform transition duration-300 hover:scale-110 hover:shadow-2xl"
        >
            <img src="{{ $nodo['foto'] ?? 'https://via.placeholder.com/150' }}" alt="{{ $nodo['nombre'] }}" class="w-full h-full object-cover">
        </div>

        <!-- NOMBRE Y CARGO -->
        <div class="mt-3 bg-white shadow-xl rounded-xl px-5 py-3 text-center border border-gray-200 transition transform group-hover:-translate-y-1 group-hover:shadow-2xl">
            <h3 class="font-bold text-gray-800 text-lg">{{ $nodo['nombre'] }}</h3>
            <p class="text-sm text-gray-600">{{ $nodo['cargo'] }}</p>
            <p class="text-xs text-[#00713D] font-semibold">{{ $nodo['area'] }}</p>
        </div>

        <!-- TARJETA EMERGENTE (MODAL) -->
        <div 
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        >
            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md relative">
                <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-xl font-bold">✕</button>
                
                <!-- FOTO GRANDE -->
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-[#00713D] shadow-lg">
                        <img src="{{ $nodo['foto'] ?? 'https://via.placeholder.com/150' }}" alt="{{ $nodo['nombre'] }}" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mt-4">{{ $nodo['nombre'] }}</h2>
                    <p class="text-gray-600 mt-1">{{ $nodo['cargo'] }}</p>
                    <p class="text-[#00713D] font-semibold">{{ $nodo['area'] }}</p>
                </div>

                <!-- INFO EXTRA -->
                <div class="mt-5 text-sm text-gray-700 space-y-2">
                    <p><strong>Email:</strong> {{ $nodo['email'] ?? 'No disponible' }}</p>
                    <p><strong>Tel:</strong> {{ $nodo['telefono'] ?? 'No disponible' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CONECTOR VERTICAL -->
    @if(isset($nodo['hijos']))
        <div class="relative flex flex-col items-center">
            <!-- Línea vertical que conecta con hijos -->
            <div class="w-px h-6 bg-gray-300"></div>
            
            <!-- HIJOS -->
            <ul class="flex flex-wrap justify-center gap-8 mt-6 border-t-2 border-gray-300 pt-6">
                @foreach($nodo['hijos'] as $hijo)
                    <x-nodo :nodo="$hijo" />
                @endforeach
            </ul>
        </div>
    @endif

</li>
