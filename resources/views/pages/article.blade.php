@extends('layouts.app')

@section('title')
    Artikel
@endsection

@section('content')
    <main>
        <div class="trending-area fix">
            <div class="container">
                <div class="trending-main">
                    <!-- Header -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="trending-tittle">
                                <strong>Trending now</strong>
                                <div class="trending-animated">
                                    <ul id="js-news" class="js-hidden">
                                        <li class="news-item" >{{ $currentDate }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Search Bar -->
                        <div class="col-lg-4 col-12 mb-md-0 mb-4">
                            <div class="header-area">
                                <div class="main-header">
                                    <div class="header-right-btn f-right">
                                        <i class="fas fa-search special-tag"></i>
                                        <div class="search-box">
                                            <form action="{{ route('artikel') }}" method="GET">
                                                <input type="text" name="search" placeholder="Cari artikel..."
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

                @if (!request('search') && !request('category'))
                    {{-- Hanya tampil jika tidak ada pencarian --}}
                    <div class="recent-articles mt-4">
                        <div class="recent-wrapper">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="section-tittle mb-30">
                                        <h3>Artikel Terbaru</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="recent-active dot-style d-flex">
                                        @forelse ($articleLatest as $item)
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
                                            <p>Belum ada Artikel Terbaru.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Filter dan Daftar Artikel -->
                <div class="mt-4">
                    <div class="row">
                        <!-- Filter Kategori -->
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-lg-8 col-12">
                                    <div class="filter-category mb-4">
                                        <h5>Filter Kategori</h5>
                                        <div style="width: 200px;">
                                            <form action="{{ route('artikel') }}" method="GET">
                                                <!-- Dropdown Kategori -->
                                                <select name="category" class="form-select" onchange="this.form.submit()">
                                                    <option value="">Semua Kategori</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->slug }}"
                                                            {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <!-- Tetap Sertakan Search di Form -->
                                                @if (request('search'))
                                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12"></div>
                            </div>
                        </div>

                        <!-- Judul Hasil Pencarian -->
                        <div class="col-12 mb-4">
                            <h3>
                                @if (request('search') || request('category'))
                                    Hasil Pencarian
                                    @if (request('category'))
                                        untuk Kategori
                                        <strong>{{ $categories->firstWhere('slug', request('category'))->name ?? '' }}</strong>
                                    @endif
                                    @if (request('search'))
                                        dengan Kata Kunci <strong>"{{ request('search') }}"</strong>
                                    @endif
                                @else
                                    Semua Artikel
                                @endif
                            </h3>
                        </div>

                        <!-- Daftar Artikel -->
                        <div class="col-12">
                            <div class="row">
                                @forelse ($article as $index => $item)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="article-area">
                                            <a href="{{ route('detail-artikel', $item->slug) }}" class="article-detail">
                                                <div class="single-article">
                                                    <!-- Gambar Artikel -->
                                                    <div class="image-article">
                                                        <img src="{{ Storage::url($item->image) }}" alt=""
                                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 10px">
                                                        <div class="article-date color{{ ($index % 4) + 1 }}" style="padding: 4px 15px; color: #353535; border-radius: 4px; font-size: 13px">
                                                            {{ \Carbon\Carbon::parse($item->publish_date)->translatedFormat('l, d F Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="article-caption mt-2">
                                                        <h5>{{ \Illuminate\Support\Str::limit($item->title, 60, '...') }}
                                                        </h5>
                                                        <div class="desc" style="color: #222 !important">
                                                            {!! $item->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <h5>Artikel tidak ditemukan.</h5>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $article->appends(['category' => request('category'), 'search' => request('search')])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection