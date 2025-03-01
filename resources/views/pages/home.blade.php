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
                                            <span>{{ \Carbon\Carbon::parse($trending->publish_date)->translatedFormat('l, d F Y') }}</span>
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
                                                        class="color1">{{ \Carbon\Carbon::parse($item->publish_date)->translatedFormat('l, d F Y') }}</span>
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
                                        <span
                                            class="color{{ ($index % 4) + 1 }}">{{ $item->categoryArticle->name }}</span>
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
        </div>
        <div class="trending-area fix" style="padding-top: 50px">
            <div class="container">
                <div class="news-all">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-tittle mb-30">
                                <h3>Berita Terbaru</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($latestNews as $index => $item)
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="{{ route('detail-berita', $item->slug) }}" class="news-detail">
                                    <div class="single-news mb-100">
                                        <div class="news-img">
                                            <img src="{{ Storage::url($item->image) }}" alt="" style="">
                                            <span
                                                class="news-date color{{ ($index % 4) + 1 }}">{{ \Carbon\Carbon::parse($item->publish_date)->translatedFormat('l, d F Y') }}</span>
                                        </div>
                                        <div class="news-caption">
                                            <div>
                                                <p class="title">
                                                    {{ $item->title }}</p>
                                            </div>
                                            <div class="desc">
                                                {!! $item->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-lg-12">
                                <div class="section-tittle mb-30">
                                    <h3>Belum ada berita</h3>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="weekly2-news-area  weekly2-pading">
            <div class="container">
                <div class="weekly2-wrapper">
                    <!-- section Tittle -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-tittle mb-30">
                                <h3>Berita Terbaik Bulan Ini</h3>
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
                                            <span class="color1">Berita Bulanan</span>
                                            <p>
                                                {{ \Carbon\Carbon::parse($item->publish_date)->translatedFormat('l, d F Y') }}
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
        
        <div class="gray-bg" style="padding: 40px 0">
            <div class="container whats-news-area " >
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="col-12">
                            <h2 class="contact-title">Saran</h2>
                        </div>
                        <div class="col-12">
                            <form class="form-contact contact_form" action="send_email.php" method="post" id="contactForm">
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
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Masukkan your name'"
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
                    <div class="col-lg-4 d-none d-md-block">
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
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
