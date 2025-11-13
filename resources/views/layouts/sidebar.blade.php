<!-- AlpineJS y RemixIcon -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

<style>
    /* Scrollbar personalizado */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>

<!-- Contenedor principal con Alpine -->
<div x-data="{ 
  openSidebar: true, 
  openMenu: null, 
  userMenuOpen: false
}" 
class="min-h-screen bg-gray-50 dark:bg-gray-900">

  <!-- Sidebar -->
  <div class="sidebar fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 
              dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 text-white 
              transform transition-transform duration-300 ease-in-out z-50 lg:translate-x-0
              border-r border-slate-700/50 dark:border-gray-700/50 flex flex-col overflow-hidden"
       :class="openSidebar ? 'translate-x-0' : '-translate-x-full'">

    <!-- Header -->
    <div class="px-4 py-6 border-b border-slate-700/50 dark:border-gray-700/50 relative flex-shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg">
          <i class="ri-government-line text-xl"></i>
        </div>
        <div class="flex-1">
          <h2 class="font-bold text-sm text-white">SIGAT</h2>
          <p class="text-xs text-slate-400 dark:text-gray-400">Sistema Gobierno</p>
        </div>
      </div>
      <!-- Botón cerrar móvil -->
      <button @click="openSidebar = false" 
              class="lg:hidden absolute top-4 right-4 text-slate-400 hover:text-white">
        <i class="ri-close-line text-xl"></i>
      </button>
    </div>

    <!-- Menú con scroll independiente -->
    <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto custom-scrollbar">

      <!-- DASHBOARDS -->
      <div>
        <button @click="openMenu = (openMenu === 'dashboards' ? null : 'dashboards')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg 
                       hover:bg-slate-800/50 dark:hover:bg-gray-800/50 transition group">
          <span class="flex items-center gap-3 text-sm">
            <i class="ri-dashboard-2-line text-slate-400 dark:text-gray-400 group-hover:text-green-400 transition"></i>
            <span class="text-slate-300 dark:text-gray-300 group-hover:text-white transition">Dashboards</span>
          </span>
          <i class="ri-arrow-right-s-line text-slate-400 dark:text-gray-400 transition-transform duration-200"
             :class="openMenu === 'dashboards' ? 'rotate-90 text-green-400' : ''"></i>
        </button>
 
        <div x-show="openMenu === 'dashboards'" x-collapse 
             class="ml-9 mt-1 space-y-0.5 border-l-2 border-slate-700/50 dark:border-gray-700/50 pl-3">
          
          {{-- Administrador puede ver TODOS los dashboards --}}
          @role('Administrador')
            <a href="{{ route('dashboard-administrador') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-administrador') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Administrador
            </a>
            <a href="{{ route('dashboard-presidente-municipal') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-presidente-municipal') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Presidente Municipal
            </a>
            <a href="{{ route('dashboard-sindico-procurador') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-sindico-procurador') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Síndico Procurador
            </a>
            <a href="{{ route('dashboard-regidor') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-regidor') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Regidor
            </a>
            <a href="{{ route('dashboard-director-de-area') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-director-de-area') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Director de Área
            </a>
            <a href="{{ route('dashboard-auxiliar-area') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-auxiliar-area') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Auxiliar de Área
            </a>
          @endrole

          {{-- Cada rol solo ve SU dashboard --}}
          @role('Presidente Municipal')
            <a href="{{ route('dashboard-presidente-municipal') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-presidente-municipal') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Presidente Municipal
            </a>
          @endrole

          @role('Síndico Procurador')
            <a href="{{ route('dashboard-sindico-procurador') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-sindico-procurador') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Síndico Procurador
            </a>
          @endrole

          @role('Regidor')
            <a href="{{ route('dashboard-regidor') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-regidor') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Regidor
            </a>
          @endrole

          @role('Director de Área')
            <a href="{{ route('dashboard-director-de-area') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-director-de-area') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Director de Área
            </a>
          @endrole

          @role('Auxiliar de Área')
            <a href="{{ route('dashboard-auxiliar-area') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('dashboard-auxiliar-area') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Auxiliar de Área
            </a>
          @endrole

        </div>
      </div>

      <!-- INFORMES -->
      <div>
        <button @click="openMenu = (openMenu === 'informes' ? null : 'informes')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg 
                       hover:bg-slate-800/50 dark:hover:bg-gray-800/50 transition group">
          <span class="flex items-center gap-3 text-sm">
            <i class="ri-file-list-line text-slate-400 dark:text-gray-400 group-hover:text-green-400 transition"></i>
            <span class="text-slate-300 dark:text-gray-300 group-hover:text-white transition">Informe</span>
          </span>
          <i class="ri-arrow-right-s-line text-slate-400 dark:text-gray-400 transition-transform duration-200"
             :class="openMenu === 'informes' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'informes'" x-collapse 
             class="ml-9 mt-1 space-y-0.5 border-l-2 border-slate-700/50 dark:border-gray-700/50 pl-3">
          
          {{-- Solo roles con permiso pueden generar informes --}}
          @can('generar informes')
            <a href="{{ url('generar-informe') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->is('generar-informe') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Generar Informe
            </a>
          @endcan

          {{-- Todos pueden ver informes generados --}}
          @can('visualizar informes')
            <a href="{{ route('informes-generados') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('informes-generados') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Informes Generados
            </a>
          @endcan
        </div>
      </div>

      <!-- ACTIVIDADES -->
      <div>
        <button @click="openMenu = (openMenu === 'actividades' ? null : 'actividades')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg 
                       hover:bg-slate-800/50 dark:hover:bg-gray-800/50 transition group">
          <span class="flex items-center gap-3 text-sm">
            <i class="ri-calendar-check-line text-slate-400 dark:text-gray-400 group-hover:text-green-400 transition"></i>
            <span class="text-slate-300 dark:text-gray-300 group-hover:text-white transition">Actividades</span>
          </span>
          <i class="ri-arrow-right-s-line text-slate-400 dark:text-gray-400 transition-transform duration-200"
             :class="openMenu === 'actividades' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'actividades'" x-collapse 
             class="ml-9 mt-1 space-y-0.5 border-l-2 border-slate-700/50 dark:border-gray-700/50 pl-3">
          
          {{-- Solo roles con permiso pueden crear actividades --}}
          @can('crear actividades')
            <a href="{{ url('dashboard-actividades') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->is('dashboard-actividades') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Generar Actividad
            </a>
          @endcan

          {{-- Todos pueden ver actividades registradas --}}
          @can('ver actividades')
            <a href="{{ route('actividades.registradas') }}" 
               class="block px-3 py-2 text-sm rounded-lg transition
                      {{ request()->routeIs('actividades.registradas') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
              Actividades Registradas
            </a>
          @endcan
        </div>
      </div>

      <!-- USUARIOS (solo Administrador) -->
      @role('Administrador')
      <div>
        <button @click="openMenu = (openMenu === 'usuarios' ? null : 'usuarios')"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg 
                       hover:bg-slate-800/50 dark:hover:bg-gray-800/50 transition group">
          <span class="flex items-center gap-3 text-sm">
            <i class="ri-team-line text-slate-400 dark:text-gray-400 group-hover:text-green-400 transition"></i>
            <span class="text-slate-300 dark:text-gray-300 group-hover:text-white transition">Usuarios</span>
          </span>
          <i class="ri-arrow-right-s-line text-slate-400 dark:text-gray-400 transition-transform duration-200"
             :class="openMenu === 'usuarios' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'usuarios'" x-collapse 
             class="ml-9 mt-1 space-y-0.5 border-l-2 border-slate-700/50 dark:border-gray-700/50 pl-3">
          <a href="{{ url('dashboard-users') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->is('dashboard-users') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Registro de Usuarios
          </a>
          <a href="{{ route('dashboard-crear-usuario') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->routeIs('dashboard-crear-usuario') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Crear Usuario
          </a>

          <a href="{{ route('roles') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->routeIs('roles') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Roles y Permisos
          </a>
        </div>
      </div>
      @endrole

      <!-- SITIO PÚBLICO (todos) -->
      <div>
        <a href="{{ route('inicio') }}" target="_blank"
           class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg 
                  hover:bg-slate-800/50 dark:hover:bg-gray-800/50 transition group">
          <span class="flex items-center gap-3 text-sm">
            <i class="ri-global-line text-slate-400 dark:text-gray-400 group-hover:text-green-400 transition"></i>
            <span class="text-slate-300 dark:text-gray-300 group-hover:text-white transition">Ver Sitio Público</span>
          </span>
          <i class="ri-external-link-line text-slate-400 dark:text-gray-400 group-hover:text-green-400 transition text-xs"></i>
        </a>
      </div>

    </nav>

    <!-- Footer fijo (siempre visible) -->
<div class="mt-auto border-t border-slate-700/50 dark:border-gray-700/50 flex-shrink-0">
  
  {{-- 1️⃣ DARK MODE --}}
  <div class="px-4 py-3 border-b border-slate-700/50 dark:border-gray-700/50">
    <button @click="instantDarkMode()"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg bg-slate-800/30 dark:bg-gray-800/30 hover:bg-slate-800/50 dark:hover:bg-gray-800/50 transition group"
            x-data="{
                instantDarkMode() {
                    const style = document.createElement('style');
                    style.id = 'disable-transitions';
                    style.innerHTML = '* { transition: none !important; }';
                    document.head.appendChild(style);
                    
                    $store.theme.toggle();
                    
                    document.body.offsetHeight;
                    
                    setTimeout(() => {
                        const styleEl = document.getElementById('disable-transitions');
                        if (styleEl) styleEl.remove();
                    }, 50);
                }
            }">
      <i class="ri-contrast-2-line text-slate-400 dark:text-gray-400 group-hover:text-green-400 transition"></i>
      <span class="text-sm text-slate-300 dark:text-gray-300 group-hover:text-white transition">Modo Oscuro</span>
      <div class="ml-auto w-9 h-5 bg-slate-700 dark:bg-gray-700 rounded-full relative transition-colors duration-200"
           :class="{ 'bg-green-600': $store.theme.darkMode }">
        <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200"
             :class="{ 'translate-x-4': $store.theme.darkMode }"></div>
      </div>
    </button>
  </div>

{{-- 2️⃣ NOTIFICACIONES --}}
<div class="px-4 py-3 border-b border-slate-700/50 dark:border-gray-700/50">
    <div x-data="{
         showNotifications: false,
         notifications: [],
         unreadCount: 0,
         loading: false,
         
         init() {
             this.loadNotifications();
             setInterval(() => this.loadNotifications(), 60000);
             
             // Cerrar al navegar
             window.addEventListener('beforeunload', () => {
                 this.showNotifications = false;
             });
         },
         
         async loadNotifications() {
             this.loading = true;
             try {
                 const response = await fetch('{{ route('notifications.recent') }}');
                 const data = await response.json();
                 this.notifications = data.notifications;
                 this.unreadCount = data.unread_count;
             } catch (error) {
                 console.error('Error loading notifications:', error);
             }
             this.loading = false;
         },
         
         async markAsRead(id) {
             try {
                 await fetch(`/notificaciones/${id}/read`, {
                     method: 'POST',
                     headers: {
                         'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                     }
                 });
                 this.loadNotifications();
             } catch (error) {
                 console.error('Error marking as read:', error);
             }
         },
         
         async markAllAsRead() {
             try {
                 await fetch('{{ route('notifications.readAll') }}', {
                     method: 'POST',
                     headers: {
                         'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                     }
                 });
                 this.loadNotifications();
             } catch (error) {
                 console.error('Error marking all as read:', error);
             }
         },
         
         closePanel() {
             this.showNotifications = false;
         }
     }">
        
        <div class="relative">
            {{-- Botón de notificaciones --}}
            <button @click="showNotifications = !showNotifications; if(showNotifications) loadNotifications()"
                    class="w-full flex items-center justify-between p-3 rounded-xl bg-slate-800/50 dark:bg-gray-800/50 hover:bg-slate-800 dark:hover:bg-gray-800 transition cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <i class="ri-notification-3-line text-xl text-slate-300 dark:text-gray-300 group-hover:text-white transition"></i>
                        {{-- Badge contador --}}
                        <span x-show="unreadCount > 0"
                              x-text="unreadCount > 99 ? '99+' : unreadCount"
                              class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 animate-pulse">
                        </span>
                    </div>
                    <span class="text-sm text-slate-300 dark:text-gray-300 group-hover:text-white transition">
                        Notificaciones
                    </span>
                </div>
                <i class="ri-arrow-right-s-line text-slate-400 dark:text-gray-400 transition-transform duration-200"
                   :class="showNotifications ? 'rotate-90' : ''"></i>
            </button>
            
            {{-- Panel de notificaciones --}}
            <div x-show="showNotifications"
                 x-cloak
                 @click.outside="closePanel()"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="absolute bottom-full left-0 right-0 mb-2 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 max-h-[500px] overflow-hidden flex flex-col z-50"
                 style="display: none;">
                
                {{-- Header --}}
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <i class="ri-notification-3-line text-green-600"></i>
                        Notificaciones
                    </h3>
                    <button @click="markAllAsRead()"
                            x-show="unreadCount > 0"
                            class="text-xs text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                        Marcar todas como leídas
                    </button>
                </div>
                
                {{-- Lista de notificaciones --}}
                <div class="overflow-y-auto flex-1">
                    {{-- Loading --}}
                    <div x-show="loading" class="p-8 text-center">
                        <i class="ri-loader-4-line text-3xl text-gray-400 animate-spin"></i>
                    </div>
                    
                    {{-- Sin notificaciones --}}
                    <div x-show="!loading && notifications.length === 0" 
                         class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="ri-notification-off-line text-5xl mb-3 opacity-50"></i>
                        <p class="text-sm">No tienes notificaciones</p>
                    </div>
                    
                    {{-- Lista --}}
                    <template x-for="notif in notifications" :key="notif.id">
                        <div class="block p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                             :class="!notif.read ? 'bg-blue-50 dark:bg-blue-900/10' : ''">
                            <div class="flex items-start gap-3">
                                {{-- Icono --}}
                                <div :class="{
                                    'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400': notif.color === 'blue',
                                    'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400': notif.color === 'green',
                                    'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400': notif.color === 'red',
                                    'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400': notif.color === 'yellow'
                                }" class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i :class="notif.icon" class="text-lg"></i>
                                </div>
                                
                                {{-- Contenido --}}
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-sm text-gray-900 dark:text-gray-100 mb-1" x-text="notif.title"></p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2" x-text="notif.message"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1" 
                                       x-text="new Date(notif.created_at).toLocaleString('es-ES', {
                                           day: '2-digit',
                                           month: 'short',
                                           hour: '2-digit',
                                           minute: '2-digit'
                                       })"></p>
                                    
                                    {{-- Acciones --}}
                                    <div class="flex items-center gap-3 mt-2">
                                        <a x-show="notif.link" 
                                           :href="notif.link"
                                           @click="markAsRead(notif.id); closePanel();"
                                           class="text-xs text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium">
                                            Ver detalles →
                                        </a>
                                        
                                        <button x-show="!notif.read"
                                                @click.stop="markAsRead(notif.id)"
                                                class="text-xs text-gray-600 hover:text-gray-800 dark:text-gray-400">
                                            Marcar como leída
                                        </button>
                                    </div>
                                </div>
                                
                                {{-- Indicador no leída --}}
                                <div x-show="!notif.read" class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>
                            </div>
                        </div>
                    </template>
                </div>
                
                {{-- Footer --}}
                <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <a href="{{ route('notifications.index') }}"
                       class="block text-center text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                        Ver todas las notificaciones
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

  {{-- 3️⃣ USUARIO --}}
  <div class="px-4 py-3 bg-slate-900/50 dark:bg-gray-900/50">
    <button @click="userMenuOpen = !userMenuOpen" 
            class="w-full flex items-center gap-3 p-2.5 rounded-xl bg-slate-800/50 dark:bg-gray-800/50 hover:bg-slate-800 dark:hover:bg-gray-800 transition cursor-pointer group">
      <img src="{{ asset('images/' . (Auth::user()->avatar ?? 'default.jpg')) }}" 
           alt="{{ Auth::user()->name }}"
           class="w-9 h-9 rounded-full object-cover flex-shrink-0"
           onerror="this.src='{{ asset('images/default.jpg') }}'">
      <div class="flex-1 min-w-0 text-left">
        <p class="font-medium text-sm truncate text-white">{{ Auth::user()->name ?? 'Usuario' }}</p>
        <p class="text-xs text-slate-400 dark:text-gray-400 truncate">
          {{ Auth::user()->roles->first()->name ?? 'Sin rol' }}
        </p>
      </div>
      <i class="ri-arrow-up-s-line text-slate-400 dark:text-gray-400 group-hover:text-slate-300 dark:group-hover:text-gray-300 transition transform"
         :class="{ 'rotate-180': userMenuOpen }"></i>
    </button>

    {{-- Menú desplegable del usuario --}}
    <div x-show="userMenuOpen" 
         x-collapse
         class="mt-2 py-2 bg-slate-800/80 dark:bg-gray-800/80 rounded-lg border border-slate-700/50 dark:border-gray-700/50 space-y-1">
      
      {{-- Link al dashboard del usuario según su rol --}}
      @role('Administrador')
        <a href="{{ route('dashboard-administrador') }}" 
           class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
          <i class="ri-dashboard-line text-slate-400 dark:text-gray-400"></i>
          <span>Dashboard</span>
        </a>
      @endrole

      @role('Presidente Municipal')
        <a href="{{ route('dashboard-presidente-municipal') }}" 
           class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
          <i class="ri-dashboard-line text-slate-400 dark:text-gray-400"></i>
          <span>Dashboard</span>
        </a>
      @endrole

      @role('Síndico Procurador')
        <a href="{{ route('dashboard-sindico-procurador') }}" 
           class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
          <i class="ri-dashboard-line text-slate-400 dark:text-gray-400"></i>
          <span>Dashboard</span>
        </a>
      @endrole

      @role('Regidor')
        <a href="{{ route('dashboard-regidor') }}" 
           class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
          <i class="ri-dashboard-line text-slate-400 dark:text-gray-400"></i>
          <span>Dashboard</span>
        </a>
      @endrole

      @role('Director de Área')
        <a href="{{ route('dashboard-director-de-area') }}" 
           class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
          <i class="ri-dashboard-line text-slate-400 dark:text-gray-400"></i>
          <span>Dashboard</span>
        </a>
      @endrole

      @role('Auxiliar de Área')
        <a href="{{ route('dashboard-auxiliar-area') }}" 
           class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
          <i class="ri-dashboard-line text-slate-400 dark:text-gray-400"></i>
          <span>Dashboard</span>
        </a>
      @endrole

      <a href="{{ route('perfil.index') }}"               
        class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded
        {{ request()->routeIs('perfil.index') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : '' }}">
        <i class="ri-user-settings-line text-slate-400 dark:text-gray-400"></i>
        <span>Mi Perfil</span>
      </a>

      <div class="border-t border-slate-700/50 dark:border-gray-700/50 my-1"></div>

      <form method="POST" action="{{ route('logout') }}" class="w-full">
        @csrf
        <button type="submit" 
                class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition rounded">
          <i class="ri-logout-box-r-line"></i>
          <span>Cerrar Sesión</span>
        </button>
      </form>
    </div>
  </div>
</div>

  <!-- Botón para abrir sidebar en móvil -->
  <button @click="openSidebar = true" 
          class="lg:hidden fixed top-4 left-4 z-40 w-10 h-10 bg-slate-900 dark:bg-gray-900 text-white rounded-lg shadow-lg flex items-center justify-center"
          x-show="!openSidebar">
    <i class="ri-menu-line text-xl"></i>
  </button>

  <!-- Overlay para cerrar en móvil -->
  <div x-show="openSidebar" 
       @click="openSidebar = false"
       class="lg:hidden fixed inset-0 bg-black/50 z-40"
       x-transition:enter="transition-opacity ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition-opacity ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0">
    </div>
  </div>
</div>