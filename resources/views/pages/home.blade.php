@extends('layouts.app')

@section('content')
    <!-- Preloader Start -->
    {{-- <div id="preloader-active">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="preloader-circle"></div>
                    <div class="preloader-img pere-text">
                        <img src="assets/img/logo/logo.png" alt="">
                    </div>
                </div>
            </div>
        </div>  --}}
    <!-- Preloader Start -->

    <main>
        <!-- Trending Area Start -->
        <div class="trending-area fix">
            <div class="container">
                <div class="trending-main">
                    <!-- Trending Tittle -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="trending-tittle">
                                <strong>Trending now</strong>
                                <div class="trending-animated">
                                    <ul id="js-news" class="js-hidden">
                                        <li class="news-item">{{ $currentDate }}</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Trending Top -->
                            @if ($trending)
                                <div class="trending-top mb-30">
                                    <div class="trend-top-img">
                                        <img src="{{ Storage::url($trending->image) }}" alt="">
                                        <div class="trend-top-cap">
                                            <span>{{ \Carbon\Carbon::parse($trending->updated_at)->translatedFormat('l, d F Y') }}</span>
                                            <h2><a
                                                    href="{{ route('detail-berita', $trending->slug) }}">{{ $trending->title }}</a>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="trending-top mb-30">
                                    <p class="text-center">Tidak ada berita</p>
                                </div>
                            @endif
                            <!-- Trending Bottom -->
                            <div class="trending-bottom">
                                <div class="row">
                                    @forelse ($topTrending as $item)
                                        <div class="col-lg-4">
                                            <div class="single-bottom mb-35">
                                                <div class="trend-bottom-img mb-20">
                                                    <img src="{{ Storage::url($item->image) }}" alt="">
                                                </div>
                                                <div class="trend-bottom-cap">
                                                    <span
                                                        class="color1">{{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('l, d F Y') }}</span>
                                                    <h4><a
                                                            href="{{ route('detail-berita', $item->slug) }}">{{ $item->title }}</a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p>No trending articles available.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <!-- Riht content -->
                        <div class="col-lg-4">
                            <div class="d-flex">
                                <h3 class="mb-15">Artikel</h3>
                            </div>
                            @forelse ($topTrendingArticle as $index => $item)
                                <div class="trand-right-single d-flex">
                                    <div style="width: 35%; height: 100px;">
                                        <img src="{{ Storage::url($item->image) }}" alt=""
                                            style="object-fit: cover; width: 100%; height: 100%; border-radius: 5px;">
                                    </div>
                                    <div class="trand-right-cap" style="width: 65%">
                                        <span class="color{{ ($index % 4) + 1 }}">{{ $item->categoryArticle->name }}</span>
                                        <h4><a
                                                href="{{ route('detail-artikel', $item->slug) }}">{{ \Illuminate\Support\Str::limit($item->title, 40, '...') }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @empty
                                <p>No trending articles available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="recent-articles mt-4">
                <div class="container">
                    <div class="recent-wrapper">
                        <!-- section Tittle -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-tittle mb-30">
                                    <h3>Artikel Terbaru</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="recent-active dot-style d-flex dot-style">
                                    @forelse ($newArticle as $item)
                                        <div class="single-recent mb-100">
                                            <div class="what-img" style="height: 250px;">
                                                <img src="{{ Storage::url($item->image) }}" alt=""
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 5px;">
                                            </div>
                                            <div class="what-cap">
                                                <span class="color1">{{ $item->articleContributor->name }}</span>
                                                <h4><a
                                                        href="{{ route('detail-artikel', $item->slug) }}">{{ \Illuminate\Support\Str::limit($item->title, 50, '...') }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="whats-news-area pt-20 pb-20">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row d-flex justify-content-between">
                                <div class="col-lg-6 col-md-6">
                                    <div class="section-tittle mb-30">
                                        <h3>Kontributor</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="properties__button">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <!-- Nav Card -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab">
                                            <div class="whats-news-caption">
                                                <div class="row">
                                                    @forelse ($contributor as $item)
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="single-what-news mb-100">
                                                                <div class="what-img" style="height: 300px;">
                                                                    @if ($item->profile_photo)
                                                                        <img src="{{ Storage::url($item->profile_photo) }}"
                                                                            alt=""
                                                                            style="object-fit: cover; width: 100%; height: 100%; border-radius: 5px;">
                                                                    @else
                                                                        <img src="https://unsplash.com/illustrations/man-tv-news-reader-or-presenter-at-his-desk-flat-vector-illustration-isolated-on-white-background-anchorman-or-reporter-cartoon-character-in-news-studio-az-yh7q8mqs"
                                                                            alt="Default Image"
                                                                            style="object-fit: cover; width: 100%; height: 100%; border-radius: 5px;">
                                                                    @endif
                                                                </div>
                                                                <div class="what-cap">
                                                                    <span class="color1">Kontributor</span>
                                                                    <h4><a href="#">{{ $item->name }}</a></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>No contributors found.</p>
                                                    @endforelse

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Nav Card -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Section Tittle -->
                            <div class="section-tittle mb-40">
                                <h3>Follow Us</h3>
                            </div>
                            <!-- Flow Socail -->
                            <div class="single-follow mb-45">
                                <div class="single-box">
                                    <div class="follow-us d-flex align-items-center">
                                        <div class="follow-social">
                                            <a href="#"><img
                                                    src="{{ asset('assets/frontend/assets/img/news/icon-fb.png') }}"
                                                    alt=""></a>
                                        </div>
                                        <div class="follow-count">
                                            <span>8,045</span>
                                            <p>Fans</p>
                                        </div>
                                    </div>
                                    <div class="follow-us d-flex align-items-center">
                                        <div class="follow-social">
                                            <a href="#"><img
                                                    src="{{ asset('assets/frontend/assets/img/news/icon-tw.png') }}"
                                                    alt=""></a>
                                        </div>
                                        <div class="follow-count">
                                            <span>8,045</span>
                                            <p>Fans</p>
                                        </div>
                                    </div>
                                    <div class="follow-us d-flex align-items-center">
                                        <div class="follow-social">
                                            <a href="#"><img
                                                    src="{{ asset('assets/frontend/assets/img/news/icon-ins.png') }}"
                                                    alt=""></a>
                                        </div>
                                        <div class="follow-count">
                                            <span>8,045</span>
                                            <p>Fans</p>
                                        </div>
                                    </div>
                                    <div class="follow-us d-flex align-items-center">
                                        <div class="follow-social">
                                            <a href="#"><img
                                                    src="{{ asset('assets/frontend/assets/img/news/icon-yo.png') }}"
                                                    alt=""></a>
                                        </div>
                                        <div class="follow-count">
                                            <span>8,045</span>
                                            <p>Fans</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- New Poster -->
                            <div class="news-poster d-none d-lg-block">
                                <img src="assets/img/news/news_card.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="weekly2-news-area  weekly2-pading gray-bg">
            <div class="container">
                <div class="weekly2-wrapper">
                    <!-- section Tittle -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-tittle mb-30">
                                <h3>Berita Terbaik Minggu Ini</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="weekly2-news-active dot-style d-flex dot-style">
                                @forelse ($weeklyNews as $item)
                                    <div class="weekly2-single">
                                        <div class="weekly2-img">
                                            <img src="{{ Storage::url($item->image) }}" alt=""
                                                style="object-fit: cover; width: 100%; height: 150px; border-radius: 5px;">
                                        </div>
                                        <div class="weekly2-caption">
                                            <span class="color1">Berita Mingguan</span>
                                            <p>
                                                {{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('l, d F Y') }}
                                            </p>
                                            <h4><a
                                                    href="{{ route('detail-berita', $item->slug) }}">{{ $item->title }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4 px-lg-10" style="width: 100%">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Saran</h2>
                </div>
                <div class="col-12">
                    <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm"
                        novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Pesan'" placeholder=" Masukkan Pesan"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="name" id="name" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan your name'"
                                        placeholder="Masukkan your name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email"
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Masukkan email address'" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Subject'"
                                        placeholder="Masukkan Subject">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
