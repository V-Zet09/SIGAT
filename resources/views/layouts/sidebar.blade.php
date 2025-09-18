<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Contenedor con Alpine -->
<div 
    x-data="{ 
        openSidebar: true, 
        openMenu: null, 
        darkMode: localStorage.getItem('dark') === 'true' 
    }"
    x-init="$watch('darkMode', val => { 
        localStorage.setItem('dark', val); 
        document.documentElement.classList.toggle('dark', val);
    })"
>

  <!-- Sidebar -->
  <div class="sidebar fixed inset-y-0 left-0 w-64 bg-green-700/95 backdrop-blur-md text-white
              transform transition-transform duration-300 ease-in-out z-50 lg:translate-x-0
              rounded-r-3xl shadow-xl shadow-black/30 flex flex-col overflow-y-auto">

    <!-- Usuario -->
    <div class="px-6 py-8 text-center border-b border-white/20 relative">
        <div class="w-20 h-20 mx-auto rounded-full bg-white/20 flex items-center justify-center">
            <i class="ri-user-3-line text-3xl drop-shadow-md"></i>
        </div>
        <a href="/dashboard-administrador"> 
            <h2 class="mt-3 font-semibold text-white hover:text-gray-100 drop-shadow-md">Usuario</h2>
        </a>
        <p class="text-xs text-white/80 drop-shadow-sm">Administrador</p>
    </div>

    <!-- Menú -->
    <nav class="flex-1 px-4 py-6 space-y-6">

      <!-- PANEL -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/80 mb-2 drop-shadow-md">Paneles</p>
        <button @click="openMenu = (openMenu === 'dashboards' ? null : 'dashboards')"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition drop-shadow-sm">
          <span class="flex items-center gap-2">
            <i class="ri-dashboard-2-line"></i> Dashboards
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'dashboards' ? 'rotate-90 text-green-400' : ''"></i>
        </button>
 
        <div x-show="openMenu === 'dashboards'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ route('dashboard-administrador') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white
                    {{ request()->routeIs('dashboard-administrador') ? 'bg-green-600 text-white font-semibold drop-shadow-md' : 'text-white/80 drop-shadow-sm' }}">
            Administrador
          </a>
          <a href="{{ route('dashboard-presidente-municipal') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Presidente Municipal
          </a>
          <a href="{{ route('dashboard-sindico-procurador') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Síndico Procurador
          </a>
          <a href="{{ route('dashboard-regidor') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Regidor
          </a>
          <a href="{{ route('dashboard-director-de-area') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Director de Área
          </a>
          <a href="{{ route('dashboard-auxiliar-area') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Auxiliar de Área
          </a>
        </div>
      </div>

      <!-- INFORMES -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/80 mb-2 drop-shadow-md">Informes</p>
        <button @click="openMenu = (openMenu === 'informes' ? null : 'informes')"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition drop-shadow-sm">
          <span class="flex items-center gap-2">
            <i class="ri-file-list-line"></i> Informe
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'informes' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'informes'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ url('generar-informe') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Generar Informe
          </a>
          <a href="{{ route('informes-generados') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Informes Generados
          </a>
        </div>
      </div>

      <!-- ACTIVIDADES -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/80 mb-2 drop-shadow-md">Actividades</p>
        <button @click="openMenu = (openMenu === 'actividades' ? null : 'actividades')"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition drop-shadow-sm">
          <span class="flex items-center gap-2">
            <i class="ri-calendar-check-line"></i> Actividades
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'actividades' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'actividades'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ url('dashboard-actividades') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Generar Actividad
          </a>
          <a href="{{ route('actividades.registradas') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Actividades Registradas
          </a>
        </div>
      </div>

      <!-- USUARIOS -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/80 mb-2 drop-shadow-md">Usuarios</p>
        <button @click="openMenu = (openMenu === 'usuarios' ? null : 'usuarios')"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition drop-shadow-sm">
          <span class="flex items-center gap-2">
            <i class="ri-team-line"></i> Usuarios
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'usuarios' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'usuarios'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ url('dashboard-users') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            CRUD
          </a>
          <a href="{{ route('dashboard-crear-usuario') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Crear Usuario
          </a>
          <a href="{{ route('roles') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Roles
          </a>
          <a href="{{ route('roles-simple') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Roles simple
          </a>
        </div>
      </div>
    </nav>

    <!-- Footer: botones -->
    <div class="px-6 py-4 border-t border-white/20 flex justify-center gap-4">
        <!-- Configuración -->
        <a href="/ajustes" 
           class="text-white hover:text-gray-100 transition drop-shadow-sm flex items-center justify-center p-2 rounded-lg">
            <i class="ri-settings-3-line text-3xl cursor-pointer"></i>
        </a>

        <!-- Dark Mode -->
        <button @click="darkMode = !darkMode" 
                class="text-white hover:text-gray-100 transition drop-shadow-sm flex items-center justify-center p-2 rounded-lg">
            <i class="ri-moon-line text-3xl cursor-pointer"></i>
        </button>

        <!-- Logout con tooltip compacto -->
        <div x-data="{ tooltip: false }" class="relative flex items-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        @mouseenter="tooltip = true" @mouseleave="tooltip = false"
                        class="flex items-center justify-center w-12 h-12 text-white transition shadow-lg bg-red-500/80 hover:bg-red-500 rounded-lg">
                    <i class="ri-logout-box-r-line text-2xl"></i>
                </button>

                <!-- Tooltip -->
                <div x-show="tooltip"
                     class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded shadow-lg whitespace-nowrap"
                     x-transition.duration.150ms>
                    Cerrar Sesión
                </div>
            </form>
        </div>
    </div>
  </div>
</div>