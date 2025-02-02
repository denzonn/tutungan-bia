@extends('layouts.app')

@section('title')
    Profil
@endsection

@section('content')
    <main>
        <!-- About US Start -->
        <div class="about-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Trending Tittle -->
                        <div class="about-right mb-90">
                            <div class="section-tittle mb-30 pt-30">
                                <h3>Tentang Kami</h3>
                            </div>
                            <div class="about-prea" style="text-align: justify">
                                {!! $data->content !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row d-flex justify-content-between">
                            <div class="section-tittle mb-10 pt-30" >
                                <h3 class="mb-0">Kontributor</h3>
                                <p style="font-size: 12px; color: gray">Kontributor yang berperan dalam membagikan informasi
                                </p>
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
                                                            <div class="what-img" style="height: 180px;">
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
                </div>
            </div>
        </div>
        <!-- About US End -->
    </main>
@endsection
