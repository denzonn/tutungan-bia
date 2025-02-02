@extends('layouts.app')

@section('title')
    Dokumen
@endsection

@section('content')
    <main>
        <div class="trending-area fix">
            <div class="container">
                <div class="trending-main">
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
                    </div>
                </div>

                <div class="table document px-lg-5">
                    <h2 class="mt-2 text-center">Data Dokumen</h2>
                    {{-- Search --}}
                    <div class="row">
                        <div class="input-group mb-3">
                            <form action="{{ route('dokument') }}" method="GET">
                                <input type="text" class="form-control" placeholder="Cari dokumen..." name="search" id="searchInput" value="{{ request('search') }}" onkeydown="if(event.key === 'Enter'){this.form.submit();}">
                            </form>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 50%">Nama</th>
                                <th style="width: 45%">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if ($item->link)
                                            <a href="{{ $item->link }}" target="_blank" rel="noopener noreferrer">
                                                <i class="fa-solid fa-eye see"></i>
                                            </a>
                                        @endif
                                        @if ($item->file)
                                            <a href="{{ asset('storage/'. $item->file) }}" download="{{ $item->name }}">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $data->appends(['search' => request('search')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
