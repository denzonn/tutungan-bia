@extends('layouts.app')

@section('title')
    Berita
@endsection

@section('content')
    <main>
        <div class="trending-area fix">
            <div class="container">
                <div class="trending-main">
                    <!-- Header Pencarian -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="trending-tittle">
                                <strong>Trending now</strong>
                                <div class="trending-animated">
                                    <ul id="js-news" class="js-hidden">
                                        <li class="news-item">{{ $currentDate }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-md-0 mb-4">
                            <div class="header-area">
                                <div class="main-header">
                                    <div class="header-right-btn f-right">
                                        <i class="fas fa-search special-tag"></i>
                                        <div class="search-box">
                                            <form action="{{ route('berita') }}" method="GET">
                                                <input type="text" name="search" placeholder="Search"
                                                    value="{{ request('search') }}"
                                                    onkeydown="if (event.key === 'Enter') this.form.submit();" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Berita Terpopuler -->
                @if (!request('search'))
                    {{-- Hanya tampil jika tidak ada pencarian --}}
                    <div class="recent-articles mt-4">
                        <div class="recent-wrapper">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="section-tittle mb-30">
                                        <h3>Berita Terpopuler</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="recent-active dot-style d-flex">
                                        @forelse ($topTrending as $item)
                                            <div class="single-recent mb-100">
                                                <div class="what-img" style="height: 250px;">
                                                    <img src="{{ Storage::url($item->image) }}" alt=""
                                                        style="object-fit: cover; width: 100%; height: 100%; border-radius: 5px;">
                                                </div>
                                                <div class="what-cap">
                                                    <span class="color1">{{ $item->contributor->name }}</span>
                                                    <h4><a
                                                            href="{{ route('detail-berita', $item->slug) }}">{{ \Illuminate\Support\Str::limit($item->title, 50, '...') }}</a>
                                                    </h4>
                                                </div>
                                            </div>
                                        @empty
                                            <p>Belum ada berita trending.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Berita Lainnya -->
                <div class="news-all mt-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-tittle mb-30">
                                @if (request('search'))
                                    <h3>Hasil Pencarian untuk: {{ request('search') }}</h3>
                                @else
                                    <h3>Berita Lainnya</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($data as $index => $item)
                            <div class="col-lg-4 col-md-6">
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
                            <div class="col-lg-12">
                                <div class="section-tittle mb-30">
                                    <h3>Belum ada berita</h3>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div class="pagination-area pb-45 text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="single-wrap d-flex justify-content-center">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination justify-content-start">
                                                {{ $data->links() }}
                                            </ul>
                                        </nav>
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
