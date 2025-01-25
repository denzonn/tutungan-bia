@extends('layouts.admin')

@section('title')
    Buat Kategori Artikel - Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <a href="{{ route('kategori-artikel.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body py-md-4 px-md-5">
                <div class="text-center">
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Masukkan Kategori Artikel</h1>
                </div>
                <form action="{{ route('kategori-artikel.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" id="name" placeholder="Masukkan Nama Kategori">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection