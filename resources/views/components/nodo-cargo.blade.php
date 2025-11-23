@props(['empleado'])

<li class="relative mb-32">
    <!-- Tarjeta principal del cargo -->
    <div class="flex flex-col items-center">
        @if($loop->first ?? false)
            <!-- Presidente - Estilo especial -->
            <div class="bg-gradient-to-r from-green-200 to-green-300 rounded-xl shadow-lg p-6 w-96 border-4 border-green-400">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-green-300 to-green-400 flex items-center justify-center border-4 border-white shadow">
                            <span class="text-4xl font-bold text-white">{{ strtoupper(substr($empleado->nombre ?? '?', 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-green-900 font-bold text-lg mb-1">{{ $empleado->nombre ?? 'Posición Vacante' }}</h2>
                        <p class="text-green-800 font-semibold text-sm">{{ $empleado->puesto ?? '' }}</p>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button onclick="abrirModalEditar({{ $empleado->id }}, '{{ $empleado->nombre }}', '{{ $empleado->puesto }}', '{{ $empleado->departamento }}')"
                            class="flex-1 px-3 py-2 bg-green-700 text-white text-xs font-semibold rounded-lg hover:bg-green-800 transition shadow">
                        ✏️ Editar
                    </button>
                    <button onclick="abrirModalEliminar({{ $empleado->id }})"
                            class="flex-1 px-3 py-2 bg-red-500 text-white text-xs font-semibold rounded-lg hover:bg-red-600 transition shadow">
                        🗑️ Eliminar
                    </button>
                </div>
            </div>
        @else
            <!-- Subordinados - Tarjetas horizontales -->
            <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-lg shadow-md p-4 w-96 hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-green-200 to-green-300 flex items-center justify-center border-3 border-white shadow">
                            <span class="text-2xl font-bold text-green-900">{{ strtoupper(substr($empleado->nombre ?? '?', 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-green-900 font-bold text-sm mb-1 truncate">{{ $empleado->nombre ?? 'Posición Vacante' }}</h3>
                        <p class="text-green-700 font-semibold text-xs mb-1">{{ $empleado->puesto ?? '' }}</p>
                        @if($empleado->departamento)
                            <p class="text-green-600 text-xs">📌 {{ $empleado->departamento }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2 mt-3">
                    <button onclick="abrirModalEditar({{ $empleado->id }}, '{{ $empleado->nombre }}', '{{ $empleado->puesto }}', '{{ $empleado->departamento }}')"
                            class="flex-1 px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700 transition shadow">
                        ✏️ Editar
                    </button>
                    <button onclick="abrirModalEliminar({{ $empleado->id }})"
                            class="flex-1 px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded hover:bg-red-600 transition shadow">
                        🗑️ Eliminar
                    </button>
                </div>
            </div>
        @endif

        <!-- Línea conectora -->
        @if($empleado->subordinados && $empleado->subordinados->count() > 0)
            <div class="w-0.5 h-12 bg-gradient-to-b from-green-400 to-gray-300 mt-4"></div>
            
            <!-- Línea horizontal principal -->
            <div class="relative mb-8">
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-gray-300"></div>
            </div>

            <!-- Contenedor de subordinados -->
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center w-full px-12">
                @foreach($empleado->subordinados as $subordinado)
                    <div class="relative group w-full">
                        <!-- Línea vertical individual -->
                        <div class="absolute -top-20 left-1/2 transform -translate-x-1/2 w-0.5 h-20 bg-gradient-to-b from-gray-300 to-green-400"></div>
                        
                        <!-- Punto de conexión -->
                        <div class="absolute -top-16 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-green-400 rounded-full border-2 border-white shadow-md"></div>
                        
                        <x-nodo-cargo :empleado="$subordinado" />
                    </div>
                @endforeach
            </ul>
        @endif
    </div>
</li>

<style>
.cargo-vacio {
    opacity: 0.6;
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
}

.cargo-vacio .text-white {
    color: #a0aec0 !important;
}
</style>
