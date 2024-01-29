<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="{{ asset('template/src/assets/images/logos/dark-logo.svg') }}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item {{ Route::is('dashboard') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">MENU</span>
                </li>
                <li class="sidebar-item {{ Route::is('attachment') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('attachment') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-photo"></i>
                        </span>
                        <span class="hide-menu">Lampiran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('poly') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('poly') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-door"></i>
                        </span>
                        <span class="hide-menu">Poly</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('profile*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('profile') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-circle"></i>
                        </span>
                        <span class="hide-menu">Pasien</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('dokter*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokter') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Dokter</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('schedule') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('schedule') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-calendar"></i>
                        </span>
                        <span class="hide-menu">Jadwal</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::is('registrasi') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('registrasi') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-plus"></i>
                        </span>
                        <span class="hide-menu">Registrasi</span>
                    </a>
                </li>
                @if (Auth::user()->scope === 'super-admin')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">SETUP</span>
                    </li>
                    <li class="sidebar-item {{ Route::is('user') ? 'selected' : '' }}">
                        <a class="sidebar-link" href="{{ route('user') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="hide-menu">Account</span>
                        </a>
                    </li>
                @endif
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
