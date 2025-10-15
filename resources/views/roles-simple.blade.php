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
<div x-data="rolesTabs()" class="relative min-h-screen pt-2 pb-10 px-10 space-y-6">

    {{-- Encabezado --}}
    <div class="space-y-2 text-center">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-ayu-green to-ayu-green2 bg-clip-text text-transparent tracking-tight">👥 Gestión de Roles</h1>
        <p class="text-gray-600 dark:text-gray-300 text-lg">Administra los permisos de cada rol.</p>
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
                        <span x-text="rol.nombre"></span>
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
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2" x-text="rolesData[rolAbierto].nombre"></h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8" x-text="rolesData[rolAbierto].descripcion"></p>

                {{-- Permisos tipo acordeón --}}
                <div class="space-y-5">
                    <template x-for="(grupo, key) in rolesData[rolAbierto].permisos" :key="key">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden bg-ayu-light dark:bg-gray-900">
                            <button @click="grupo.abierto = !grupo.abierto" 
                                    class="w-full flex justify-between items-center px-5 py-4 text-left font-semibold text-gray-800 dark:text-gray-200 hover:text-ayu-green transition">
                                <span x-text="key"></span>
                                <svg :class="grupo.abierto ? 'rotate-180 text-ayu-green' : 'text-gray-400 dark:text-gray-500'" 
                                     class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="grupo.abierto" x-transition class="px-6 pb-5 space-y-3">
                                <template x-for="perm in grupo.permisos" :key="perm.nombre">
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="checkbox" 
                                               x-model="perm.activo" 
                                               class="w-4 h-4 text-ayu-green border-gray-300 dark:border-gray-600 rounded focus:ring-ayu-green">
                                        <span class="text-gray-700 dark:text-gray-300 text-sm group-hover:text-ayu-green transition" x-text="perm.nombre"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
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
function rolesTabs() {
    return {
        rolAbierto: null,
        guardando: false,
        panelVisible: false,
        underlineStyle: '',
        roles: [
            { id: 1, nombre: 'Administrador', descripcion: 'Control total del sistema' },
            { id: 2, nombre: 'Presidente', descripcion: 'Máxima autoridad del ayuntamiento' },
            { id: 3, nombre: 'Síndico', descripcion: 'Responsable legal y patrimonial' },
            { id: 4, nombre: 'Regidor', descripcion: 'Encargado de comisiones' },
            { id: 5, nombre: 'Director', descripcion: 'Gestiona áreas y proyectos' },
            { id: 6, nombre: 'Auxiliar', descripcion: 'Soporte y ayuda en tareas' },
        ],
        permisosBase: {
            'Usuarios': ['Ver usuarios','Crear usuario','Editar usuario','Eliminar usuario','Asignar roles'],
            'Actividades': ['Ver actividades','Crear actividad','Editar actividad','Aprobar actividad','Eliminar actividad'],
            'Reportes': ['Ver reportes','Exportar PDF','Exportar Excel'],
            'Finanzas': ['Ver presupuesto','Registrar gasto','Aprobar gasto'],
            'Configuración': ['Acceder a ajustes','Editar parámetros','Ver bitácora'],
            'Dashboard': ['Ver tableros','Ver métricas avanzadas'],
        },
        rolesData: {},

        openRol(id, event){
            this.rolAbierto = id;
            this.panelVisible = true;

            if(!this.rolesData[id]){
                this.rolesData[id] = {
                    id: id,
                    nombre: this.roles.find(r => r.id === id).nombre,
                    descripcion: this.roles.find(r => r.id === id).descripcion,
                    permisos: {}
                };
                for(const grupo in this.permisosBase){
                    this.rolesData[id].permisos[grupo] = {
                        abierto: false,
                        permisos: this.permisosBase[grupo].map(perm => ({ nombre: perm, activo: false }))
                    };
                }
            }

            const btn = event.currentTarget;
            this.underlineStyle = `width:${btn.offsetWidth}px; left:${btn.offsetLeft}px;`;
        },

        guardar(){
            this.guardando = true; // Mostrar animación

            setTimeout(() => {
                this.guardando = false;    // Ocultar animación
                this.panelVisible = false;  // Cerrar panel
                this.rolAbierto = null;

                // Cerrar todos los grupos abiertos
                for(const id in this.rolesData){
                    for(const grupo in this.rolesData[id].permisos){
                        this.rolesData[id].permisos[grupo].abierto = false;
                    }
                }

                // Scroll hacia encabezado
                const header = document.querySelector('h1');
                if(header){
                    header.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 700); // breve duración
        }
    }
}
</script>
@endsection
