<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="flex" x-data="{ openSidebar: true, openMenu: null }">
  <!-- Overlay móvil -->
  <div x-show="openSidebar" 
       class="fixed inset-0 bg-black/40 z-40 lg:hidden"
       @click="openSidebar = false"></div>

  <!-- Sidebar -->
  <div :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 w-64 bg-green-800/95 backdrop-blur-md text-white 
              transform transition-transform duration-300 ease-in-out z-50 lg:translate-x-0
              rounded-r-3xl shadow-xl shadow-black/30 flex flex-col">

    <!-- Usuario -->
    <div class="px-6 py-8 text-center border-b border-white/20">
      <div class="w-20 h-20 mx-auto rounded-full bg-white/20 flex items-center justify-center">
        <i class="ri-user-3-line text-3xl"></i>
      </div>
      <h2 class="mt-3 font-semibold">Usuario</h2>
      <p class="text-xs text-white/70">Administrador</p>
      <!-- Botón cerrar móvil -->
      <button @click="openSidebar = false" 
              class="lg:hidden absolute top-4 right-4 text-white/70 hover:text-white">✕</button>
    </div>

    <!-- Menú -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
      
      <!-- PANEL -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/60 mb-2">Paneles</p>
        <button @click="openMenu === 'dashboards' ? openMenu=null : openMenu='dashboards'"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition">
          <span class="flex items-center gap-2">
            <i class="ri-dashboard-2-line"></i> Dashboards
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'dashboards' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'dashboards'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ route('dashboard-administrador') }}" 
             class="block px-3 py-2 rounded-lg transition 
                    hover:bg-green-700 hover:text-white 
                    {{ request()->routeIs('dashboard-administrador') ? 'bg-green-600 text-white font-semibold shadow-md' : 'text-white/80' }}">
            Administrador
          </a>
          <a href="{{ route('dashboard-presidente-municipal') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Presidente Municipal
          </a>
          <a href="{{ route('dashboard-sindico-procurador') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Síndico Procurador
          </a>
          <a href="{{ route('dashboard-regidor') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Regidor
          </a>
          <a href="{{ route('dashboard-director-de-area') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Director de Área
          </a>
          <a href="{{ route('dashboard-auxiliar-area') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Auxiliar de Área
          </a>
        </div>
      </div>

      <!-- INFORMES -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/60 mb-2">Informes</p>
        <button @click="openMenu === 'informes' ? openMenu=null : openMenu='informes'"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition">
          <span class="flex items-center gap-2">
            <i class="ri-file-list-line"></i> Informe
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'informes' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'informes'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ url('generar-informe') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Generar Informe
          </a>
          <a href="{{ route('informes-registrados') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Informes Generados
          </a>
        </div>
      </div>

      <!-- ACTIVIDADES -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/60 mb-2">Actividades</p>
        <button @click="openMenu === 'actividades' ? openMenu=null : openMenu='actividades'"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition">
          <span class="flex items-center gap-2">
            <i class="ri-calendar-check-line"></i> Actividades
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'actividades' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'actividades'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ url('dashboard-actividades') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Generar Actividad
          </a>
          <a href="{{ route('actividades.registradas') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Actividades Registradas
          </a>
        </div>
      </div>

      <!-- USUARIOS -->
      <div>
        <p class="text-xs uppercase font-semibold text-white/60 mb-2">Usuarios</p>
        <button @click="openMenu === 'usuarios' ? openMenu=null : openMenu='usuarios'"
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl 
                       bg-white/10 hover:bg-green-600/60 transition">
          <span class="flex items-center gap-2">
            <i class="ri-team-line"></i> Usuarios
          </span>
          <i class="ri-arrow-right-s-line transition-transform"
             :class="openMenu === 'usuarios' ? 'rotate-90 text-green-400' : ''"></i>
        </button>

        <div x-show="openMenu === 'usuarios'" x-collapse 
             class="pl-8 mt-2 space-y-1 transition-all duration-300">
          <a href="{{ url('dashboard-users') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            CRUD
          </a>
          <a href="{{ route('dashboard-crear-usuario') }}" 
             class="block px-3 py-2 rounded-lg transition hover:bg-green-700 hover:text-white">
            Crear Usuario
          </a>
        </div>
      </div>
    </nav>

    <!-- Logout abajo -->
    <div class="px-6 py-6 border-t border-white/20">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" 
                class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 transition">
          <i class="ri-logout-box-r-line"></i> Logout
        </button>
      </form>
    </div>
  </div>

  <!-- Contenido -->
  <div class="flex-1 lg:ml-64 transition-all duration-300">
    <button @click="openSidebar = true" class="p-2 lg:hidden">
      ☰
    </button>
    <div class="p-6">
      @yield('content')
    </div>
  </div>
</div>
