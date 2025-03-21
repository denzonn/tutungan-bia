@extends('layouts.app')

@section('title')
    {{ $data->title }}
@endsection

@section('content')
    <main class='news-detail-area'>
        <div class="share-buttons" id="shareButtons">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                class="share-btn facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank"
                class="share-btn twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode(url()->current()) }}" target="_blank"
                class="share-btn whatsapp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}" target="_blank"
                class="share-btn telegram">
                <i class="fab fa-telegram"></i>
            </a>
        </div>
        <div class="trending-area fix">
            <div class="trending-main">
                <div class="container">
                    <div class="mt-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('berita') }}">Berita</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="news-detail">
                                <div class="news-img">
                                    <img src="{{ Storage::url($data->image) }}" alt="">
                                </div>
                                <div class="news-caption">
                                    <h2>{{ $data->title }}</h2>
                                    <div class="news-date">
                                        <div class="social-share">
                                            <div class="d-flex align-items-center">
                                                <span class="mr-2">Share:</span>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('detail-berita', $data->slug) }}"
                                                    target="_blank" class="facebook"><i
                                                        class="fa-brands fa-facebook"></i></a>
                                                <a href="https://twitter.com/intent/tweet?url={{ route('detail-berita', $data->slug) }}"
                                                    target="_blank" class="twitter"><i class="fa-brands fa-twitter"></i></a>
                                                <a href="https://wa.me/?text={{ route('detail-berita', $data->slug) }}"
                                                    target="_blank" class="whatsapp"><i
                                                        class="fa-brands fa-whatsapp"></i></a>
                                                <a href="https://t.me/share/url?url={{ route('detail-berita', $data->slug) }}"
                                                    target="_blank" class="telegram"><i
                                                        class="fa-brands fa-telegram"></i></a>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div>{{ formatVisits($data->click_count) }} views</div>
                                        <div class="divider"></div>
                                        <div>{{ \Carbon\Carbon::parse($data->publish_date)->format('d F Y') }}</div>
                                    </div>
                                </div>
                                <hr class="mt-2">
                                <div class="news-content text-justify">
                                    {!! preg_replace(
                                        '/<a(.*?)href="(.*?)"/i',
                                        '<a$1href="$2" target="_blank" rel="noopener noreferrer"',
                                        $data->content,
                                    ) !!}
                                </div>
                                <div class="news-contributor-editor">
                                    <div class="news-contributor-img">
                                        <img src="{{ $data->reporter->profile_photo
                                            ? asset('storage/' . $data->reporter->profile_photo)
                                            : asset('images/user.png') }}"
                                            alt="">
                                    </div>
                                    <div class="contributor-editor">
                                        <div class="news-contributor">
                                            <div>{{ $data->reporter->name }}</div>
                                        </div>
                                        <div class="news-editor">
                                            <div>Editor : {{ $data->editor->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="d-flex">
                                <h3 class="mb-15">Berita Terpopuler</h3>
                            </div>
                            @forelse ($topTrending as $index => $item)
                                <div class="trand-right-single d-flex">
                                    <div style="width: 35%; height: 115px;">
                                        <img src="{{ Storage::url($item->image) }}" alt=""
                                            style="object-fit: cover; width: 100%; height: 100%; border-radius: 5px;">
                                    </div>
                                    <div class="trand-right-cap" style="width: 65%">
                                        <span class="color{{ ($index % 4) + 1 }} mb-2">{{ $item->reporter->name }}</span>
                                        <h4><a
                                                href="{{ route('detail-berita', $item->slug) }}">{{ \Illuminate\Support\Str::limit($item->title, 55, '...') }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @empty
                                <p>No trending articles available.</p>
                            @endforelse
                        </div>
                    </div>
                    <hr>
                    <div class="news-all">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-tittle mb-30">
                                    <h3>Berita Lainnya</h3>
                                </div>
                            </div>
                            @forelse ($readAlso as $index => $item)
                                <div class="col-lg-3 col-md-6">
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
                                                        {{ \Illuminate\Support\Str::limit($item->title, 80, '...') }}</p>
                                                </div>
                                                <div class="desc">
                                                    {!! $item->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-lg-3 col-md-6">
                                    <p>Tidak ada berita</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection

@push('addon-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let shareButtons = document.getElementById("shareButtons");
            let lastScrollTop = 0;

            window.addEventListener("scroll", function() {
                let scrollTop = window.scrollY || document.documentElement.scrollTop;

                if (scrollTop > 100) { // Tampilkan jika scroll lebih dari 100px
                    shareButtons.style.right = "0px"; // Muncul
                } else {
                    shareButtons.style.right = "-60px"; // Sembunyikan
                }

                lastScrollTop = scrollTop;
            });
        });
    </script>
@endpush
