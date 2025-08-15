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
</style>

<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo -->
        <a href="<?php echo e(route('dashboard-administrador')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/SIGAT.jpeg')); ?>" alt="SIGAT Logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/SIGAT.jpeg')); ?>" alt="SIGAT Logo" height="40">
            </span>
        </a>

        <!-- Light Logo -->
        <a href="<?php echo e(route('dashboard-administrador')); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/SIGAT.jpeg')); ?>" alt="SIGAT Logo" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/SIGAT.jpeg')); ?>" alt="SIGAT Logo" height="40">
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
                    src="<?php if(Auth::user()->avatar != ''): ?> <?php echo e(URL::asset('images/' . Auth::user()->avatar)); ?> <?php else: ?> <?php echo e(URL::asset('build/images/users/avatar-1.jpg')); ?> <?php endif; ?>"
                    alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text"><?php echo e(Auth::user()->name); ?></span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text">
                        <i class="ri ri-circle-fill fs-10 text-success align-baseline"></i>
                        <span class="align-middle">Online</span>
                    </span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <h6 class="dropdown-header">Bienvenido <?php echo e(Auth::user()->name); ?>!</h6>
            <a class="dropdown-item" href="<?php echo e(url('pages-profile')); ?>">
                <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> Perfil
            </a>
            <a class="dropdown-item" href="<?php echo e(url('apps-chat')); ?>">
                <i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> Mensajes
            </a>
            <a class="dropdown-item" href="<?php echo e(url('apps-tasks-kanban')); ?>">
                <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> Tareas
            </a>
            <a class="dropdown-item" href="<?php echo e(url('pages-faqs')); ?>">
                <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> Ayuda
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo e(url('pages-profile')); ?>">
                <i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> Balance: <b>$5971.67</b>
            </a>
            <a class="dropdown-item" href="<?php echo e(url('pages-profile-settings')); ?>">
                <span class="badge bg-success-subtle text-success mt-1 float-end">Nuevo</span>
                <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> Configuración
            </a>
            <a class="dropdown-item" href="<?php echo e(url('auth-lockscreen-basic')); ?>">
                <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> Bloquear pantalla
            </a>
            <a class="dropdown-item" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Cerrar sesión
            </a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
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
                        <i class="ri-dashboard-2-line"></i> <span>Dashboards</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a href="<?php echo e(route('dashboard-administrador')); ?>" class="nav-link"><i class="fas fa-user-shield me-2"></i> Administrador</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('dashboard-presidente-municipal')); ?>" class="nav-link"><i class="fas fa-user-tie me-2"></i> Presidente Municipal</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('dashboard-sindico-procurador')); ?>" class="nav-link"><i class="fas fa-balance-scale me-2"></i> Síndico Procurador</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('dashboard-regidor')); ?>" class="nav-link"><i class="fas fa-users me-2"></i> Regidor</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('dashboard-director-de-area')); ?>" class="nav-link"><i class="fas fa-user-cog me-2"></i> Director de Área</a></li>
                            <li class="nav-item"><a href="<?php echo e(route('dashboard-auxiliar-area')); ?>" class="nav-link"><i class="fas fa-user-clock me-2"></i> Auxiliar de Área</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Informes -->
                <li class="menu-title"><span>Informes</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarInforme" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarInforme">
                        <i class="ri-apps-2-line"></i> <span>Informe</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarInforme">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(url('dashboard-generar-informe')); ?>" class="nav-link">
                                    <i class="fas fa-file-upload me-2"></i> Generar Informe
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Actividades -->
                <li class="menu-title"><span>Actividades</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarActividades" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarActividades">
                        <i class="ri-apps-2-line"></i> <span>Actividades</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarActividades">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(url('dashboard-actividades')); ?>" class="nav-link">
                                    <i class="fas fa-plus-circle me-2"></i> Generar Actividad
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('actividades.registradas')); ?>" class="nav-link">
                                    <i class="fas fa-tasks me-2"></i> Actividades Registradas
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
                        <i class="ri-layout-3-line"></i> <span>Layouts</span>
                        <span class="badge badge-pill bg-danger">Hot</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item"><a href="<?php echo e(url('layouts-horizontal')); ?>" target="_blank" class="nav-link">Horizontal</a></li>
                            <li class="nav-item"><a href="<?php echo e(url('layouts-detached')); ?>" target="_blank" class="nav-link">Detached</a></li>
                            <li class="nav-item"><a href="<?php echo e(url('layouts-two-column')); ?>" target="_blank" class="nav-link">Two Column</a></li>
                            <li class="nav-item"><a href="<?php echo e(url('layouts-vertical-hovered')); ?>" target="_blank" class="nav-link">Hovered</a></li>
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
<?php /**PATH C:\Users\zaet_\OneDrive\Escritorio\AYUNTAMIENTO\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>