@props(['nodo'])

<li class="relative list-none flex flex-col items-center">

    <!-- Tarjeta simple -->
    <div class="flex flex-col items-center mb-6">
        <div class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-center">
            <h3 class="font-semibold text-gray-800 text-base">{{ $nodo['nombre'] }}</h3>
            <p class="text-sm text-gray-600">{{ $nodo['cargo'] }}</p>
            <p class="text-xs text-[#00713D] font-medium">{{ $nodo['area'] }}</p>
        </div>
    </div>

    <!-- Conector + hijos -->
    @if(isset($nodo['hijos']))
        <div class="relative flex flex-col items-center">
            <!-- Línea vertical -->
            <div class="w-px h-4 bg-gray-300"></div>

            <!-- Hijos -->
            <ul class="flex flex-wrap justify-center gap-6 mt-4 pt-4 border-t border-gray-200">
                @foreach($nodo['hijos'] as $hijo)
                    <x-nodo :nodo="$hijo" />
                @endforeach
            </ul>
        </div>
    @endif

</li>
