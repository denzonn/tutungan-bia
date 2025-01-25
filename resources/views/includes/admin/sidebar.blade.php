<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Tutungan Bia'</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Informasi
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ Route::is('berita.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('berita.index') }}">
            <i class="fa fa-solid fa-newspaper"></i>
            <span>Berita</span></a>
    </li>

    {{-- Role selain SUPERADMIN --}}
    @role(['ADMIN', 'CONTRIBUTOR'])
        <li class="nav-item {{ Route::is('artikel.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('artikel.index') }}">
                <i class="fa fa-solid fa-book"></i>
                <span>Artikel</span></a>
        </li>
    @endrole

    @role('SUPERADMIN')
        <li class="nav-item {{ Route::is('kategori-artikel.index') || Route::is('artikel.index') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-solid fa-book"></i>
                <span>Artikel</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Artikel : </h6>
                    <a class="collapse-item" href="{{ route('kategori-artikel.index') }}">Kategori Artikel</a>
                    <a class="collapse-item" href="{{ route('artikel.index') }}">Artikel</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Tables -->
        <li class="nav-item {{ Route::is('admin.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.profile') }}">
                <i class="fa fa-solid fa-building"></i>
                <span>Profil</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item {{ Route::is('dokumen.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dokumen.index') }}">
                <i class="fa fa-solid fa-file"></i>
                <span>Dokumen</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            Pengguna
        </div>

        <!-- Nav Item - Tables -->
        <li class="nav-item  {{ Route::is('user.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fa fa-solid fa-user"></i>
                <span>Pengguna</span></a>
        </li>
    @endrole

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
