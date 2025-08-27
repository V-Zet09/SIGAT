<style>
    /* Scroll solo en el área de ítems del menú */
    #scrollbar {
        max-height: calc(100vh - 160px); /* Ajusta según el alto del logo + usuario */
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Scrollbar personalizado opcional */
    #scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    #scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.3);
        border-radius: 3px;
    }

    /* Eliminar flecha automática generada por el template */
    .menu-link::after {
        content: none !important;
    }

    /* Estilos para las flechas del menú manuales */
    .menu-arrow {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    /* Rotación de la flecha cuando el menú está expandido */
    [aria-expanded="true"] .menu-arrow {
        transform: rotate(90deg);
    }

    /* Estilo para el elemento activo */
    .navbar-nav .nav-item .nav-link.active {
        color: #0ab39c;
        background-color: rgba(10, 179, 156, 0.1);
    }
</style>


<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo -->
        <a href="{{ route('dashboard-administrador') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/SIGAT.jpeg') }}" alt="SIGAT Logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/SIGAT.jpeg') }}" alt="SIGAT Logo" height="40">
            </span>
        </a>

        <!-- Light Logo -->
        <a href="{{ route('dashboard-administrador') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/SIGAT.jpeg') }}" alt="SIGAT Logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/SIGAT.jpeg') }}" alt="SIGAT Logo" height="40">
            </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <!-- Usuario -->
    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user"
                    src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }} @else {{ URL::asset('build/images/users/avatar-1.jpg') }} @endif"
                    alt="Header Avatar">    
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">{{ Auth::user()->name }}</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text">
                        <i class="ri ri-circle-fill fs-10 text-success align-baseline"></i>
                        <span class="align-middle">Online</span>
                    </span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <h6 class="dropdown-header">Bienvenido {{ Auth::user()->name }}!</h6>
            <a class="dropdown-item" href="{{ url('pages-profile') }}">
                <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> Perfil
            </a>
            <a class="dropdown-item" href="{{ url('apps-chat') }}">
                <i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> Mensajes
            </a>
            <a class="dropdown-item" href="{{ url('apps-tasks-kanban') }}">
                <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> Tareas
            </a>
            <a class="dropdown-item" href="{{ url('pages-faqs') }}">
                <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> Ayuda
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ url('pages-profile') }}">
                <i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> Balance: <b>$5971.67</b>
            </a>
            <a class="dropdown-item" href="{{ url('pages-profile-settings') }}">
                <span class="badge bg-success-subtle text-success mt-1 float-end">Nuevo</span>
                <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> Configuración
            </a>
            <a class="dropdown-item" href="{{ url('auth-lockscreen-basic') }}">
                <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> Bloquear pantalla
            </a>
            <a class="dropdown-item" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Cerrar sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

   <!-- Menú principal -->
<div id="scrollbar">
    <div class="container-fluid">
        <ul class="navbar-nav" id="navbar-nav">
            <!-- Paneles -->
            <li class="menu-title"><span>Paneles</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarDashboards">
                    <i class="ri-dashboard-2-line"></i>
                    <span>Dashboards</span>
                    <i class="ri-arrow-right-s-line menu-arrow"></i>
                </a>
                <div class="collapse menu-dropdown" id="sidebarDashboards">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('dashboard-administrador') }}" class="nav-link"><i class="fas fa-user-shield me-2"></i> Administrador</a></li>
                        <li class="nav-item"><a href="{{ route('dashboard-presidente-municipal') }}" class="nav-link"><i class="fas fa-user-tie me-2"></i> Presidente Municipal</a></li>
                        <li class="nav-item"><a href="{{ route('dashboard-sindico-procurador') }}" class="nav-link"><i class="fas fa-balance-scale me-2"></i> Síndico Procurador</a></li>
                        <li class="nav-item"><a href="{{ route('dashboard-regidor') }}" class="nav-link"><i class="fas fa-users me-2"></i> Regidor</a></li>
                        <li class="nav-item"><a href="{{ route('dashboard-director-de-area') }}" class="nav-link"><i class="fas fa-user-cog me-2"></i> Director de Área</a></li>
                        <li class="nav-item"><a href="{{ route('dashboard-auxiliar-area') }}" class="nav-link"><i class="fas fa-user-clock me-2"></i> Auxiliar de Área</a></li>
                    </ul>
                </div>
            </li>

            <!-- Informes -->
            <li class="menu-title"><span>Informes</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarInforme" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarInforme">
                    <i class="ri-apps-2-line"></i>
                    <span>Informe</span>
                    <i class="ri-arrow-right-s-line menu-arrow"></i>
                </a>
                <div class="collapse menu-dropdown" id="sidebarInforme">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('generar-informe') }}" class="nav-link">
                                <i class="fas fa-file-upload me-2"></i> Generar Informe
                            </a>
                        </li>
<<<<<<< HEAD
=======
                        <li class="nav-item">
                            <a href="{{ route('informes-registrados') }}" class="nav-link">
                                <i class="fas fa-file-alt me-2"></i> Informes Generados
                            </a>
>>>>>>> a50cd93 (Prueba 1)
                    </ul>
                </div>
            </li>

            <!-- Actividades -->
            <li class="menu-title"><span>Actividades</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarActividades" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarActividades">
                    <i class="ri-apps-2-line"></i>
                    <span>Actividades</span>
                    <i class="ri-arrow-right-s-line menu-arrow"></i>
                </a>
                <div class="collapse menu-dropdown" id="sidebarActividades">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('dashboard-actividades') }}" class="nav-link">
                                <i class="fas fa-plus-circle me-2"></i> Generar Actividad
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('actividades.registradas') }}" class="nav-link">
                                <i class="fas fa-tasks me-2"></i> Actividades Registradas
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Usuarios -->
            <li class="menu-title"><span>Usuarios</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarUsuarios" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarUsuarios">
                    <i class="ri-apps-2-line"></i>
                    <span>Usuarios</span>
                    <i class="ri-arrow-right-s-line menu-arrow"></i>
                </a>
                <div class="collapse menu-dropdown" id="sidebarUsuarios">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('dashboard-users') }}" class="nav-link">
                                <i class="fas fa-plus-circle me-2"></i> CRUD
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard-crear-usuario') }}" class="nav-link">
                                <i class="fas fa-user-plus me-2"></i> Crear Usuario
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Diseños -->
            <li class="menu-title"><span>Diseños</span></li>  
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-layout-3-line"></i>
                    <span>Layouts</span>
                    <span class="badge badge-pill bg-danger">Hot</span>
                    <i class="ri-arrow-right-s-line menu-arrow"></i>
                </a>
                <div class="collapse menu-dropdown" id="sidebarLayouts">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item"><a href="{{ url('layouts-horizontal') }}" target="_blank" class="nav-link">Horizontal</a></li>
                        <li class="nav-item"><a href="{{ url('layouts-detached') }}" target="_blank" class="nav-link">Detached</a></li>
                        <li class="nav-item"><a href="{{ url('layouts-two-column') }}" target="_blank" class="nav-link">Two Column</a></li>
                        <li class="nav-item"><a href="{{ url('layouts-vertical-hovered') }}" target="_blank" class="nav-link">Hovered</a></li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>

<div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<div class="vertical-overlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el estado activo de los elementos del menú
    const menuLinks = document.querySelectorAll('.nav-link.menu-link');
    
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Cerrar otros menús abiertos (comportamiento de acordeón)
            if (!this.classList.contains('collapsed')) {
                menuLinks.forEach(otherLink => {
                    if (otherLink !== this && !otherLink.classList.contains('collapsed')) {
                        otherLink.classList.add('collapsed');
                        const target = document.querySelector(otherLink.getAttribute('href'));
                        if (target) {
                            target.classList.remove('show');
                        }
                    }
                });
            }
        });
    });
    
    // Rotar flechas cuando se expande/contrae el menú
    const collapseElements = document.querySelectorAll('.menu-dropdown');
    collapseElements.forEach(element => {
        element.addEventListener('show.bs.collapse', function() {
            const trigger = document.querySelector('[href="#' + this.id + '"]');
            if (trigger) {
                trigger.setAttribute('aria-expanded', 'true');
            }
        });
        
        element.addEventListener('hide.bs.collapse', function() {
            const trigger = document.querySelector('[href="#' + this.id + '"]');
            if (trigger) {
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    });
});
</script>