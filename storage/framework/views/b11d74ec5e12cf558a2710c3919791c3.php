<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('build/images/LOGO_VENTANA_SF.PNG')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('build/images/logo-dark.png')); ?>" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('build/images/LOGO_VENTANA_SF.PNG')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('build/images/logo-light.png')); ?>" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span><?php echo app('translator')->get('translation.dashboards'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="dashboard-analytics" class="nav-link"><?php echo app('translator')->get('Administrador'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crm" class="nav-link"><?php echo app('translator')->get('Presidente Municipal'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="index" class="nav-link"><?php echo app('translator')->get('Síndico Procurador'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crypto" class="nav-link"><?php echo app('translator')->get('Regidor'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-projects" class="nav-link"><?php echo app('translator')->get('Director de Área'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-nft" class="nav-link"> <?php echo app('translator')->get('Auxiliar de Área'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\Users\jorge\OneDrive\Documentos\GitHub\SIGAT\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>