<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Contenedor con Alpine -->
<div x-data="{ openSidebar: true, openMenu: null }">

  <!-- Sidebar -->
  <div class="sidebar fixed inset-y-0 left-0 w-64 bg-green-700/95 backdrop-blur-md text-white 
              transform transition-transform duration-300 ease-in-out z-50 lg:translate-x-0
              rounded-r-3xl shadow-xl shadow-black/30 flex flex-col overflow-y-auto"
       :class="openSidebar ? 'translate-x-0' : '-translate-x-full'">

    <!-- Usuario -->
    <div class="px-6 py-8 text-center border-b border-white/20 relative">
      <div class="w-20 h-20 mx-auto rounded-full bg-white/20 flex items-center justify-center">
        <i class="ri-user-3-line text-3xl drop-shadow-md"></i>
      </div>

      <a href="/dashboard-administrador"> 
        <h2 class="mt-3 font-semibold text-gray-200 cursor-pointer hover:text-gray-100 transition drop-shadow-md">
          Usuario
        </h2>
      </a>
      <p class="text-xs text-white/80 drop-shadow-sm">Administrador</p>
      <!-- Botón cerrar móvil -->
      <button @click="openSidebar = false" 
              class="lg:hidden absolute top-4 right-4 text-white/70 hover:text-white">✕</button>
    </div>

    <!-- Menú -->
    <nav class="flex-1 px-4 py-6 space-y-6">

      <!-- PANEL -->
      <div>
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
             class="block px-3 py-2 rounded-lg transition drop-shadow-sm
                    hover:bg-green-700 hover:text-white 
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
          <a href="{{ route('actividades.registradas') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Actividades Registradas
          </a>
        </div>
      </div>

      <!-- USUARIOS -->
      <div>
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
            Registro 
          </a>
          <a href="{{ route('roles') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white drop-shadow-sm">
            Roles
          </a>
        </div>
      </div>
    </nav>

    <!-- Footer -->
    <div class="px-6 py-3 border-t border-white/20 flex justify-center gap-6">
      <!-- Engrane -->
      <a href="/ajustes" class="text-gray-300 hover:text-gray-100 transition drop-shadow-sm">
        <i class="ri-settings-3-line text-3xl cursor-pointer"></i>
      </a>

      <!-- Modo oscuro -->
      <button type="button" 
              class="text-gray-300 hover:text-gray-100 transition drop-shadow-sm focus:outline-none p-0 m-0 bg-transparent border-none">
        <i class="ri-moon-line text-3xl cursor-pointer"></i>
      </button>
    </div>

    <!-- Logout abajo -->
    <div class="px-6 py-6 border-t border-white/20">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" 
                class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg
                 shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-xs px-4 py-2 text-center relative left-[35px] mb-2">
          <i class="ri-logout-box-r-line"></i> Cerrar Sesión
        </button>
      </form>
    </div>
  </div>
</div>
