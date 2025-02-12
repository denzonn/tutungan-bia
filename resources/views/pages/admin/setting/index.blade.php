@extends('layouts.admin')

@section('title')
    Setting - Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4 ">
            <div class="card-body py-md-4 px-md-5">
                <div class="text-center">
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Atur Setting</h1>
                </div>
                <form action="{{ route('admin.setting.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Profil Singkat</label>
                        <textarea name="short_profile" id="editor">{!! $data->short_profile !!}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">Facebook</label>
                                <input type="text" name="sosial_media_1"
                                    class="form-control @error('sosial_media_1') is-invalid @enderror"
                                    value="{{ $data->sosial_media_1 }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">Instagram</label>
                                <input type="text" name="sosial_media_2"
                                    class="form-control @error('sosial_media_2') is-invalid @enderror"
                                    value="{{ $data->sosial_media_2 }}">
                                @error('sosial_media_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">Telegram</label>
                                <input type="text" name="sosial_media_3"
                                    class="form-control @error('sosial_media_3') is-invalid @enderror"
                                    value="{{ $data->sosial_media_3 }}">
                                @error('sosial_media_3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Logo</label>
                                <input type="file" name="logo" class="form-control" accept=".png, .jpg, .jpeg"
                                    id="imageInput" />
                            </div>
                        </div>

                        <!-- Tempat Preview Gambar -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Preview Gambar:</label>
                                <div id="imagePreviewContainer" class="mt-3">
                                    @if ($data->logo)
                                        <img id="imagePreview" src="{{ Storage::url($data->logo) }}" alt="Preview Gambar"
                                            style="width: 50%; height: auto;" />
                                    @else
                                        <img id="imagePreview" src="#" alt="Preview"
                                            style="display: none; width: 50%; height: auto;" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Simpan</button>
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
