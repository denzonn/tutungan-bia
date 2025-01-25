@extends('layouts.admin')

@section('title')
    Profil - Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4 ">
            <div class="card-body py-md-4 px-md-5">
                <div class="text-center">
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Ubah Profil</h1>
                </div>
                <form action="{{ route('admin.profile.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Keterangan Profil</label>
                        <textarea name="content" id="editor">{!! $data->content !!}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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