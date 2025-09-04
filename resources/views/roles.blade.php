@extends('layouts.master')
@section('title', 'Gestión de Roles')

{{-- Tailwind y Alpine por CDN solo para esta vista (sin Vite) --}}
@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Paleta del ayuntamiento: verde más subido, blanco y toque de rojo
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ayu: {
                            green: '#27764a',  // verde subidito
                            green2: '#2f8f57',
                            red:   '#dc2626',
                            soft:  '#f7faf8'
                        }
                    },
                    boxShadow: {
                        soft: '0 6px 24px rgba(0,0,0,.06)',
                    },
                    borderRadius: {
                        xl2: '1rem'
                    }
                }
            }
        }
    </script>
@endsection

@section('content')
@php
    // Datos ficticios SOLO para diseño
    $roles = [
        ['id'=>1, 'nombre'=>'Administrador', 'descripcion'=>'Acceso total al sistema', 'usuarios'=>3, 'estado'=>'activo', 'color'=>'bg-ayu-green'],
        ['id'=>2, 'nombre'=>'Presidente',    'descripcion'=>'Gestiona actividades y reportes', 'usuarios'=>1, 'estado'=>'activo', 'color'=>'bg-ayu-green2'],
        ['id'=>3, 'nombre'=>'Síndico',       'descripcion'=>'Supervisa áreas jurídicas', 'usuarios'=>2, 'estado'=>'activo', 'color'=>'bg-ayu-green'],
        ['id'=>4, 'nombre'=>'Regidor',       'descripcion'=>'Acceso limitado a su área', 'usuarios'=>5, 'estado'=>'inactivo', 'color'=>'bg-gray-400'],
    ];

    $permisos = [
        'Usuarios'       => ['Ver usuarios','Crear usuario','Editar usuario','Eliminar usuario','Asignar roles'],
        'Actividades'    => ['Ver actividades','Crear actividad','Editar actividad','Aprobar actividad','Eliminar actividad'],
        'Reportes'       => ['Ver reportes','Exportar PDF','Exportar Excel'],
        'Finanzas'       => ['Ver presupuesto','Registrar gasto','Aprobar gasto'],
        'Configuración'  => ['Acceder a ajustes','Editar parámetros','Ver bitácora'],
        'Dashboard'      => ['Ver tableros','Ver métricas avanzadas'],
    ];
@endphp

<div x-data="rolesUI()" class="min-h-screen bg-ayu-soft/60">
    {{-- Encabezado / Migas --}}
    <div class="px-6 pt-6">
        @if (View::exists('components.breadcrumb'))
            @component('components.breadcrumb')
                @slot('li_1') Configuración @endslot
                @slot('title') Gestión de Roles @endslot
            @endcomponent
        @else
            <div class="text-sm text-gray-500">Configuración / <span class="text-ayu-green font-semibold">Gestión de Roles</span></div>
        @endif
    </div>

    {{-- Header --}}
    <div class="px-6 mt-3 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 tracking-tight">👥 Gestión de Roles</h1>
            <p class="text-gray-500">Administra los roles del sistema, sus permisos y miembros asignados.</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="openImport = true"
                    class="px-3 py-2 text-sm rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                Importar
            </button>
            <button @click="exportar()"
                    class="px-3 py-2 text-sm rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                Exportar
            </button>
            <button @click="openCreate = true; formMode='create'"
                    class="px-4 py-2 text-sm rounded-lg shadow-soft bg-ayu-green text-white hover:bg-ayu-green2">
                + Nuevo Rol
            </button>
        </div>
    </div>

    {{-- Tarjetas de métricas --}}
    <div class="px-6 mt-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl2 shadow-soft p-4 border border-gray-100">
            <div class="text-gray-500 text-sm">Roles Totales</div>
            <div class="mt-1 text-2xl font-semibold text-gray-800">{{ count($roles) }}</div>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft p-4 border border-gray-100">
            <div class="text-gray-500 text-sm">Usuarios asignados</div>
            <div class="mt-1 text-2xl font-semibold text-gray-800">
                {{ array_sum(array_map(fn($r)=>$r['usuarios'], $roles)) }}
            </div>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft p-4 border border-gray-100">
            <div class="text-gray-500 text-sm">Permisos en catálogo</div>
            <div class="mt-1 text-2xl font-semibold text-gray-800">
                {{ collect($permisos)->flatten()->count() }}
            </div>
        </div>
        <div class="bg-white rounded-xl2 shadow-soft p-4 border border-gray-100">
            <div class="text-gray-500 text-sm">Última actualización</div>
            <div class="mt-1 text-2xl font-semibold text-gray-800">Hoy</div>
        </div>
    </div>

    {{-- Filtros y búsqueda --}}
    <div class="px-6 mt-6 bg-white rounded-xl2 shadow-soft border border-gray-100">
        <div class="p-4 flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">
            <div class="flex-1 flex items-center gap-3">
                <div class="relative w-full lg:w-80">
                    <input x-model="query" type="text" placeholder="Buscar por nombre o descripción..."
                           class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-ayu-green" />
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 20l-4.35-4.35a7.5 7.5 0 10-1.41 1.41L20 21l1-1zM4.5 10a5.5 5.5 0 1111 0 5.5 5.5 0 01-11 0z"/>
                    </svg>
                </div>
                <select x-model="filtroEstado"
                        class="px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-ayu-green">
                    <option value="">Todos</option>
                    <option value="activo">Activos</option>
                    <option value="inactivo">Inactivos</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button @click="limpiar()"
                        class="px-3 py-2 text-sm rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                    Limpiar
                </button>
                <button @click="aplicar()"
                        class="px-4 py-2 text-sm rounded-lg bg-ayu-green text-white hover:bg-ayu-green2">
                    Aplicar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="px-6 mt-4">
        <div class="bg-white rounded-xl2 shadow-soft border border-gray-100 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-ayu-green text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">#</th>
                        <th class="px-4 py-3 text-left font-semibold">Rol</th>
                        <th class="px-4 py-3 text-left font-semibold">Descripción</th>
                        <th class="px-4 py-3 text-center font-semibold">Usuarios</th>
                        <th class="px-4 py-3 text-center font-semibold">Estado</th>
                        <th class="px-4 py-3 text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $rol['id'] }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full {{ $rol['color'] }}"></span>
                                    <span class="font-medium text-gray-800">{{ $rol['nombre'] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $rol['descripcion'] }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2.2rem] px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                    {{ $rol['usuarios'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($rol['estado']==='activo')
                                    <span class="px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">Activo</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <button @click="openView=true; current={{ Js::from($rol) }}"
                                            class="px-3 py-1.5 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                                        Ver
                                    </button>
                                    <button @click="openCreate=true; formMode='edit'; loadRole({{ Js::from($rol) }})"
                                            class="px-3 py-1.5 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                                        Editar
                                    </button>
                                    <button @click="openDelete=true; current={{ Js::from($rol) }}"
                                            class="px-3 py-1.5 rounded-lg bg-ayu-red text-white hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Drawer Crear/Editar --}}
    <div x-cloak x-show="openCreate"
         class="fixed inset-0 z-40"
         x-transition.opacity>
        <div @click="openCreate=false" class="absolute inset-0 bg-black/30"></div>

        <div x-show="openCreate" x-transition
             class="absolute right-0 top-0 h-full w-full max-w-xl bg-white shadow-2xl border-l border-gray-100 overflow-y-auto">
            <div class="p-6 flex items-start justify-between border-b">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800" x-text="formMode==='create' ? 'Nuevo Rol' : 'Editar Rol'"></h3>
                    <p class="text-gray-500 text-sm">Define el nombre, descripción y permisos del rol.</p>
                </div>
                <button @click="openCreate=false" class="p-2 rounded hover:bg-gray-100">
                    ✕
                </button>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nombre del rol</label>
                    <input x-model="form.nombre" @input="slugify()"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-ayu-green">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Slug</label>
                    <input x-model="form.slug" readonly
                           class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-600">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">Descripción</label>
                    <textarea x-model="form.descripcion" rows="3"
                              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-ayu-green"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Estado</label>
                        <select x-model="form.estado"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-ayu-green">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Color</label>
                        <div class="flex items-center gap-2">
                            <span :class="form.color" class="inline-block w-6 h-6 rounded-full border border-gray-300"></span>
                            <select x-model="form.color"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-ayu-green">
                                <option value="bg-ayu-green">Verde institucional</option>
                                <option value="bg-ayu-green2">Verde intenso</option>
                                <option value="bg-gray-400">Gris</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Permisos --}}
                <div class="border rounded-xl2">
                    <div class="px-4 py-3 border-b bg-gray-50 rounded-t-xl2 font-medium text-gray-800">
                        Permisos
                    </div>
                    <div class="p-4 space-y-5">
                        @foreach ($permisos as $grupo => $lista)
                            <div class="border rounded-lg">
                                <div class="px-4 py-2 bg-white flex items-center justify-between">
                                    <div class="font-semibold text-gray-800">{{ $grupo }}</div>
                                    <button type="button" class="text-sm text-ayu-green hover:underline"
                                            @click="toggleGroup('{{ \Illuminate\Support\Str::slug($grupo) }}')">
                                        (Marcar/Desmarcar)
                                    </button>
                                </div>
                                <div class="px-4 py-3 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach ($lista as $perm)
                                        @php $id = \Illuminate\Support\Str::slug($grupo.'-'.$perm); @endphp
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox"
                                                   :checked="isChecked('{{ $id }}')"
                                                   @change="togglePerm('{{ $id }}')"
                                                   class="w-4 h-4 text-ayu-green rounded border-gray-300 focus:ring-ayu-green">
                                            <span class="text-gray-700">{{ $perm }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-2">
                    <button @click="openCreate=false"
                            class="px-4 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button @click="guardar()"
                            class="px-5 py-2 rounded-lg bg-ayu-green text-white hover:bg-ayu-green2">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal ver --}}
    <div x-cloak x-show="openView" x-transition.opacity
         class="fixed inset-0 z-40 flex items-center justify-center">
        <div @click="openView=false" class="absolute inset-0 bg-black/30"></div>
        <div x-show="openView" x-transition
             class="relative bg-white w-full max-w-lg mx-4 rounded-xl2 shadow-2xl border border-gray-100">
            <div class="p-5 border-b flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Detalle del rol</h3>
                    <p class="text-sm text-gray-500">Vista rápida</p>
                </div>
                <button @click="openView=false" class="p-2 rounded hover:bg-gray-100">✕</button>
            </div>
            <div class="p-5 space-y-3 text-sm">
                <div class="flex items-center gap-2">
                    <span :class="current.color" class="inline-block w-3 h-3 rounded-full"></span>
                    <span class="font-semibold text-gray-800" x-text="current.nombre"></span>
                </div>
                <div><span class="text-gray-500">Descripción: </span><span x-text="current.descripcion"></span></div>
                <div><span class="text-gray-500">Usuarios: </span><span x-text="current.usuarios"></span></div>
                <div>
                    <span class="text-gray-500">Estado: </span>
                    <span x-show="current.estado==='activo'" class="px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">Activo</span>
                    <span x-show="current.estado!=='activo'" class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">Inactivo</span>
                </div>
            </div>
            <div class="p-4 border-t text-right">
                <button @click="openView=false" class="px-4 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">Cerrar</button>
            </div>
        </div>
    </div>

    {{-- Confirmar eliminación --}}
    <div x-cloak x-show="openDelete" x-transition.opacity
         class="fixed inset-0 z-40 flex items-center justify-center">
        <div @click="openDelete=false" class="absolute inset-0 bg-black/30"></div>
        <div x-show="openDelete" x-transition
             class="relative bg-white w-full max-w-md mx-4 rounded-xl2 shadow-2xl border border-gray-100">
            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-800">Eliminar rol</h3>
                <p class="text-gray-600 mt-1">¿Seguro que deseas eliminar el rol <span class="font-semibold" x-text="current.nombre"></span>? Esta acción no se puede deshacer.</p>
                <div class="mt-5 flex items-center justify-end gap-2">
                    <button @click="openDelete=false" class="px-4 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50">Cancelar</button>
                    <button @click="eliminar()" class="px-5 py-2 rounded-lg bg-ayu-red text-white hover:bg-red-700">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal importar (decorativo) --}}
    <div x-cloak x-show="openImport" x-transition.opacity
         class="fixed inset-0 z-40 flex items-center justify-center">
        <div @click="openImport=false" class="absolute inset-0 bg-black/30"></div>
        <div x-show="openImport" x-transition
             class="relative bg-white w-full max-w-lg mx-4 rounded-xl2 shadow-2xl border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800">Importar roles</h3>
            <p class="text-gray-600 mt-1 text-sm">Sube un archivo CSV/Excel con roles y permisos.</p>
            <div class="mt-4">
                <input type="file" class="w-full rounded-lg border border-gray-300">
            </div>
            <div class="mt-5 text-right">
                <button @click="openImport=false" class="px-4 py-2 rounded-lg bg-ayu-green text-white hover:bg-ayu-green2">Subir</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function rolesUI(){
            return {
                // estados UI
                openCreate: false,
                openView: false,
                openDelete: false,
                openImport: false,

                // filtros
                query: '',
                filtroEstado: '',

                // rol en foco
                current: {nombre:'', descripcion:'', usuarios:0, estado:'activo', color:'bg-ayu-green'},

                // modo form
                formMode: 'create',
                form: { nombre:'', slug:'', descripcion:'', estado:'activo', color:'bg-ayu-green', permisos: {} },

                // helpers
                slugify(){
                    this.form.slug = (this.form.nombre || '')
                        .toString().toLowerCase()
                        .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
                        .replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'');
                },
                loadRole(rol){
                    this.form = {
                        nombre: rol.nombre,
                        slug: rol.nombre.toLowerCase().replace(/\s+/g,'-'),
                        descripcion: rol.descripcion,
                        estado: rol.estado,
                        color: rol.color,
                        permisos: this.form.permisos || {}
                    };
                },
                togglePerm(id){
                    this.form.permisos[id] = !this.form.permisos[id];
                },
                isChecked(id){ return !!this.form.permisos[id]; },
                toggleGroup(slug){
                    // marca/desmarca por prefijo de grupo
                    const keys = Object.keys(this.form.permisos);
                    const toToggle = keys.filter(k => k.startsWith(slug));
                    const someOn = toToggle.some(k => this.form.permisos[k]);
                    toToggle.forEach(k => this.form.permisos[k] = !someOn);
                },

                aplicar(){ /* decorativo */ },
                limpiar(){ this.query=''; this.filtroEstado=''; },

                exportar(){ alert('Exportación (demo).'); },
                guardar(){ alert((this.formMode==='create'?'Creado':'Actualizado') + ' (demo)'); this.openCreate=false; },
                eliminar(){ alert('Eliminado (demo)'); this.openDelete=false; },
            }
        }
    </script>
@endsection

