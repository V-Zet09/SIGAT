<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
<!-- LOGO -->
<div class="navbar-brand-box">
    <!-- Dark Logo-->
    <a href="dashboard-administrador" class="logo logo-dark">
        <span class="logo-sm">
            <img src="{{ URL::asset('images/SIGAT.jpeg') }}" alt="SIGAT Logo" height="22">
        </span>
        <span class="logo-lg">
            <img src="{{ URL::asset('images/SIGAT.jpeg') }}" alt="SIGAT Logo" height="40">
        </span>
    </a>

    <!-- Light Logo-->
    <a href="dashboard-administrador"  class="logo logo-light">
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

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user"
                    src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('build/images/users/avatar-1.jpg') }} @endif"
                    alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">{{ Auth::user()->name }}</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
            <a class="dropdown-item" href="pages-profile"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat"><i
                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban"><i
                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs"><i
                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile"><i
                    class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance :
                    <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings"><span
                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic"><i
                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock
                    screen</span></a>

            <a class="dropdown-item " href="javascript:void();"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                    key="t-logout">@lang('translation.logout')</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/dashboard-administrador" class="nav-link">@lang('Administrador')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-presidente-municipal" class="nav-link">@lang('Presidente Municipal')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-sindico-procurador" class="nav-link">@lang('Síndico Procurador')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-regidor" class="nav-link">@lang('Regidor')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-director-de-area" class="nav-link">@lang('Director de Área')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-auxiliar-area" class="nav-link"> @lang('Auxiliar de Área')</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span>Informe</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="dashboard-generar-informe" class="nav-link">@lang('Generar Informe')</a>
                            </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="ri-layout-3-line"></i> <span>@lang('translation.layouts')</span><span
                            class="badge badge-pill bg-danger">@lang('translation.hot')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="layouts-horizontal" target="_blank" class="nav-link">@lang('translation.horizontal')</a>
                            </li>
                            <li class="nav-item">
                                <a href="layouts-detached" target="_blank" class="nav-link">@lang('translation.detached')</a>
                            </li>
                            <li class="nav-item">
                                <a href="layouts-two-column" target="_blank" class="nav-link">@lang('translation.two-column')</a>
                            </li>
                            <li class="nav-item">
                                <a href="layouts-vertical-hovered" target="_blank"
                                    class="nav-link">@lang('translation.hovered')</a>
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
