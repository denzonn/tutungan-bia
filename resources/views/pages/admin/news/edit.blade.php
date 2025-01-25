@extends('layouts.admin')

@section('title')
    Edit Berita - Admin
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
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Edit Berita</h1>
                </div>
                <form action="{{ route('berita.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Judul Berita</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ $data->title }}" required />
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Isi Berita</label>
                        <textarea name="content" id="editor">{!! $data->content !!}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Thumbnail Berita</label>
                                <input type="file" name="image" class="form-control" accept=".png, .jpg, .jpeg" id="imageInput" />
                            </div>
                        </div>

                        <!-- Tempat Preview Gambar -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Preview Gambar:</label>
                                <div id="imagePreviewContainer" class="mt-3">
                                    @if ($data->image)
                                        <img id="imagePreview" src="{{ Storage::url($data->image) }}" alt="Preview Gambar"
                                            style="width: 50%; height: auto;" />
                                    @else
                                        <img id="imagePreview" src="#" alt="Preview"
                                            style="display: none; width: 50%; height: auto;" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($data->status == 'draft' && !auth()->user()->hasRole('CONTRIBUTOR'))
                        <div class="form-group">
                            <label for="status">Status Berita</label>
                            <select name="status" id="status" class="form-control">
                                <option value="" selected>Silahkan Pilih Status</option>
                                <option value="published">Di Terima</option>
                                <option value="rejected">Di Tolak</option>
                            </select>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary">Edit Berita</button>
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

        document.getElementById('imageInput').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // Update src ke gambar baru
                    imagePreview.style.display = 'block'; // Tampilkan preview
                };
                reader.readAsDataURL(file); // Baca file sebagai data URL
            } else {
                imagePreview.src = '#';
                imagePreview.style.display = 'none'; // Sembunyikan jika tidak ada gambar
            }
        });
    </script>
@endpush
