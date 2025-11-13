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
          <a href="{{ url('generar-informe') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->is('generar-informe') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Generar Informe
          </a>
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
          <a href="{{ url('dashboard-actividades') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->is('dashboard-actividades') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Generar Actividad
          </a>
          <a href="{{ route('actividades.registradas') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->routeIs('actividades.registradas') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Actividades Registradas
          </a>
        </div>
      </div>

      <!-- USUARIOS -->
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
            CRUD
          </a>
          <a href="{{ route('dashboard-crear-usuario') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->routeIs('dashboard-crear-usuario') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Crear Usuario
          </a>
          <a href="{{ route('roles') }}" 
             class="block px-3 py-2 text-sm rounded-lg transition
                    {{ request()->routeIs('roles') ? 'text-white bg-slate-800/50 dark:bg-gray-800/50 font-medium' : 'text-slate-400 dark:text-gray-400 hover:text-white hover:bg-slate-800/30 dark:hover:bg-gray-800/30' }}">
            Roles
          </a>
        </div>
      </div>

      <!-- SITIO PÚBLICO -->
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
      
      <!-- Botón de Dark Mode con toggle bonito -->
      <div class="px-4 py-3 border-b border-slate-700/50 dark:border-gray-700/50">
        <button @click="instantDarkMode()"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg bg-slate-800/30 dark:bg-gray-800/30 hover:bg-slate-800/50 dark:hover:bg-gray-800/50 transition group"
                x-data="{
                    instantDarkMode() {
                        // 1. Deshabilitar transiciones
                        const style = document.createElement('style');
                        style.id = 'disable-transitions';
                        style.innerHTML = '* { transition: none !important; }';
                        document.head.appendChild(style);
                        
                        // 2. Cambiar tema
                        $store.theme.toggle();
                        
                        // 3. Forzar repaint
                        document.body.offsetHeight;
                        
                        // 4. Remover bloqueo
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

      <!-- Usuario con menú desplegable -->
      <div class="px-4 py-3 bg-slate-900/50 dark:bg-gray-900/50">
        <button @click="userMenuOpen = !userMenuOpen" 
                class="w-full flex items-center gap-3 p-2.5 rounded-xl bg-slate-800/50 dark:bg-gray-800/50 hover:bg-slate-800 dark:hover:bg-gray-800 transition cursor-pointer group">
          <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
            <i class="ri-user-3-line text-base"></i>
          </div>
          <div class="flex-1 min-w-0 text-left">
            <p class="font-medium text-sm truncate text-white">{{ Auth::user()->name ?? 'Usuario' }}</p>
            <p class="text-xs text-slate-400 dark:text-gray-400 truncate">{{ Auth::user()->email ?? 'email@ejemplo.com' }}</p>
          </div>
          <i class="ri-arrow-up-s-line text-slate-400 dark:text-gray-400 group-hover:text-slate-300 dark:group-hover:text-gray-300 transition transform"
             :class="{ 'rotate-180': userMenuOpen }"></i>
        </button>

        <!-- Menú desplegable del usuario -->
        <div x-show="userMenuOpen" 
             x-collapse
             class="mt-2 py-2 bg-slate-800/80 dark:bg-gray-800/80 rounded-lg border border-slate-700/50 dark:border-gray-700/50 space-y-1">
          
          <a href="/dashboard-administrador" 
             class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
            <i class="ri-dashboard-line text-slate-400 dark:text-gray-400"></i>
            <span>Dashboard</span>
          </a>

          <a href="/profile" 
             class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
            <i class="ri-user-settings-line text-slate-400 dark:text-gray-400"></i>
            <span>Mi Perfil</span>
          </a>

          <a href="/ajustes" 
             class="flex items-center gap-3 px-3 py-2 text-sm text-slate-300 dark:text-gray-300 hover:text-white hover:bg-slate-700/50 dark:hover:bg-gray-700/50 transition rounded">
            <i class="ri-settings-3-line text-slate-400 dark:text-gray-400"></i>
            <span>Configuración</span>
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