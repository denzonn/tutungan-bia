@php
    $header = \App\Models\Setting::first();
@endphp
<header>
    <!-- Header Start -->
    <div class="header-area">
        <div class="main-header">
            <div class="header-bottom header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-10 col-lg-10 col-md-12 header-flex">
                            <!-- sticky -->
                            <div class="sticky-logo">
                                <a href="{{ route('home') }}"><img src="{{ Storage::url($header->logo) }}" alt="" style="height: 50px"></a>
                            </div>
                            <!-- Main-menu -->
                            <div class="main-menu d-none d-md-block">
                                <nav>
                                    <ul id="navigation">
                                        <li class="{{ Route::is('home') ? 'active' : '' }}">
                                            <a href="{{ route('home') }}" 
                                               >
                                                Beranda
                                            </a>
                                        </li>
                                        <li class="{{ Route::is('berita') ? 'active' : '' }}">
                                            <a href="{{ route('berita') }}" 
                                               >
                                                Berita
                                            </a>
                                        </li>
                                        <li class="{{ Route::is('artikel') ? 'active' : '' }}">
                                            <a href="{{ route('artikel') }}" 
                                               >
                                                Artikel
                                            </a>
                                        </li>
                                        <li class="{{ Route::is('profil') ? 'active' : '' }}">
                                            <a href="{{ route('profil') }}" 
                                               >
                                                Profil
                                            </a>
                                        </li>
                                        <li class="{{ Route::is('dokument') ? 'active' : '' }}">
                                            <a href="{{ route('dokument') }}" 
                                               >
                                                Dokumen
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <!-- Placeholder for additional header buttons -->
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-md-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>
