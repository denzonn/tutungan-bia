@extends('layouts.admin')

@section('title')
    Edit Kategori Dokumen - Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <a href="{{ route('dokumen.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body py-md-4 px-md-5">
                <div class="text-center">
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Edit Dokumen</h1>
                </div>
                <form action="{{ route('dokumen.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $data->name }}" id="name" placeholder="Masukkan Nama" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input type="text" class="form-control @error('link') is-invalid @enderror"
                                    name="link" value="{{ $data->link }}" id="link" placeholder="Masukkan Link">
                                @error('link')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file">File</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    name="file" value="{{ old('file') }}" id="file" accept=".pdf, .doc, .docx">
                                @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <small style="color: red">Kosongkan jika tidak ingin mengubah file</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
