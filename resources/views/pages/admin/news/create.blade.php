@extends('layouts.admin')

@section('title')
    Buat Berita - Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <a href="{{ route('berita.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body py-md-4 px-md-5">
                <div class="text-center">
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Masukkan Berita</h1>
                    <p class="mb-4">Bagikan informasi terbaru dengan pembaca Anda. Gunakan editor di bawah untuk menulis
                        berita
                        yang menarik dan mudah diakses.</p>
                </div>
                <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <div class="form-group">
                                <label for="title">Judul Berita</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title') }}"  placeholder="Silahkan masukkan Judul Berita" required />
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="title">Tanggal Berita</label>
                                <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date"
                                    name="publish_date" value="{{ old('publish_date') }}" required />
                                @error('publish_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Isi Berita</label>
                        <textarea name="content" id="editor"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Thumbnail Berita</label>
                                <input type="file" name="image" class="form-control" id="imageInput" accept=".png, .jpg, .jpeg" required />
                            </div>
                        </div>

                        <!-- Tempat Preview Gambar -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Preview Gambar:</label>
                                <div id="imagePreviewContainer" class="mt-3">
                                    <img id="imagePreview" src="#" alt="Preview"
                                        style="display: none; width: 50%; height: auto;" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

        // Preview gambar setelah file diunggah
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        });
    </script>
@endpush
