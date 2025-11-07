@extends('layouts.master')  
@section('title', 'Gestión de Roles')

@section('css')
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                ayu: {
                    green: '#27764a',
                    green2: '#2f8f57',
                    light: '#ecfdf5',
                }
            },
            boxShadow: {
                glow: '0 0 25px rgba(39,118,74,.6)',
            },
            animation: {
                pulseDot: 'pulseDot 1.5s infinite',
                fadeSlide: 'fadeSlide .5s ease-out',
            },
            keyframes: {
                pulseDot: {
                    '0%,100%': { transform: 'scale(1)', opacity: '1' },
                    '50%': { transform: 'scale(1.5)', opacity: '.6' }
                },
                fadeSlide: {
                    '0%': { opacity: '0', transform: 'translateY(15px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' }
                }
            }
        }
    }
}
</script>
@endsection

@section('content')
<div x-data="rolesTabs({{ $roles->toJson() }}, {{ $permissions->toJson() }})" class="relative min-h-screen pt-2 pb-10 px-10 space-y-6">

    {{-- Encabezado --}}
    <div class="space-y-2 text-center">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-ayu-green to-ayu-green2 bg-clip-text text-transparent tracking-tight">👥 Gestión de Roles</h1>
        <p class="text-gray-600 dark:text-gray-300 text-lg">Administra los permisos de cada rol del sistema.</p>
    </div>

    {{-- Tabs --}}
    <div class="relative max-w-[calc(100%-18rem)] mx-auto px-6">
        <nav class="flex justify-between border-b border-gray-200 dark:border-gray-700 relative gap-1">
            <template x-for="rol in roles" :key="rol.id">
                <button 
                    @click="openRol(rol.id, $event)"
                    class="flex-1 text-center py-2 font-medium text-sm rounded-md transition"
                    :class="rolAbierto === rol.id 
                            ? 'text-ayu-green font-bold' 
                            : 'text-gray-500 dark:text-gray-400 hover:text-ayu-green'">
                    <span class="flex items-center justify-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-ayu-green" :class="rolAbierto===rol.id ? 'animate-pulseDot' : ''"></span>
                        <span x-text="rol.name"></span>
                    </span>
                </button>
            </template>
            <div class="absolute bottom-0 h-0.5 bg-ayu-green transition-all duration-500 ease-out"
                 :style="underlineStyle"></div>
        </nav>
    </div>

    {{-- Panel --}}
    <div class="relative">
        <template x-if="panelVisible">
            <div x-transition class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 animate-fadeSlide">

                {{-- Título --}}
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2" x-text="rolesData[rolAbierto]?.name"></h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8">Gestiona los permisos asignados a este rol</p>

                {{-- Lista de permisos --}}
                <div class="space-y-3">
                    <template x-for="perm in todosLosPermisos" :key="perm.id">
                        <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer group border border-transparent hover:border-ayu-green/30 transition">
                            <input type="checkbox" 
                                   :checked="tienePermiso(perm.id)"
                                   @change="togglePermiso(perm.id)"
                                   class="w-5 h-5 text-ayu-green border-gray-300 dark:border-gray-600 rounded focus:ring-ayu-green">
                            <span class="text-gray-700 dark:text-gray-300 group-hover:text-ayu-green transition font-medium" x-text="perm.name"></span>
                        </label>
                    </template>
                </div>

                {{-- Animación guardando --}}
                <div x-show="guardando" 
                     x-transition.opacity.duration.200ms
                     class="fixed left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 
                            bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-2xl flex items-center gap-3 z-50">
                    <svg class="w-6 h-6 text-ayu-green animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-200 font-semibold">Guardando cambios...</span>
                </div>

                {{-- Mensaje de éxito --}}
                <div x-show="exitoVisible" 
                     x-transition
                     class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Cambios guardados correctamente</span>
                </div>

                {{-- Botón --}}
                <div class="mt-8 text-right">
                    <button @click="guardar()" 
                            class="px-7 py-3 rounded-xl bg-gradient-to-r from-ayu-green to-ayu-green2 text-white font-semibold shadow-lg hover:shadow-glow transition transform hover:-translate-y-0.5 hover:scale-105">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function rolesTabs(rolesDB, permisosDB) {
    return {
        rolAbierto: null,
        guardando: false,
        exitoVisible: false,
        panelVisible: false,
        underlineStyle: '',
        roles: rolesDB,
        todosLosPermisos: permisosDB,
        rolesData: {},

        init() {
            // Inicializar datos de roles con permisos actuales
            this.roles.forEach(rol => {
                this.rolesData[rol.id] = {
                    ...rol,
                    permisosActivos: rol.permissions.map(p => p.id)
                };
            });
        },

        openRol(id, event){
            this.rolAbierto = id;
            this.panelVisible = true;

            const btn = event.currentTarget;
            this.underlineStyle = `width:${btn.offsetWidth}px; left:${btn.offsetLeft}px;`;
        },

        tienePermiso(permisoId) {
            return this.rolesData[this.rolAbierto]?.permisosActivos.includes(permisoId);
        },

        togglePermiso(permisoId) {
            const permisos = this.rolesData[this.rolAbierto].permisosActivos;
            const index = permisos.indexOf(permisoId);
            
            if (index > -1) {
                permisos.splice(index, 1);
            } else {
                permisos.push(permisoId);
            }
        },

        async guardar(){
            this.guardando = true;

            try {
                const response = await fetch(`/roles/${this.rolAbierto}/permisos`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        permisos: this.rolesData[this.rolAbierto].permisosActivos
                    })
                });

                if (response.ok) {
                    this.guardando = false;
                    this.exitoVisible = true;
                    
                    setTimeout(() => {
                        this.exitoVisible = false;
                    }, 3000);
                }
            } catch (error) {
                console.error('Error al guardar:', error);
                this.guardando = false;
                alert('Error al guardar los cambios');
            }
        }
    }
}
</script>
@endsection