@extends('layouts.admin')

@section('title')
    Buat User - Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <a href="{{ route('user.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body py-md-4 px-md-5">
                <div class="text-center">
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Tambahakan User</h1>
                </div>
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama User</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Masukkan Nama User" required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email User</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Masukkan Email User" required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}"
                                    placeholder="Masukkan Password" required />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Role User</label>
                                <select name="role" id="role"
                                    class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="" selected disabled>Pilih Role User</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Foto User</label>
                                <input type="file" name="profile_photo" class="form-control" id="imageInput" accept=".png, .jpg, .jpeg"/>
                                {{-- Tidak Wajib --}}
                                <small style="color: red">Kosongkan jika tidak ingin menambahkan foto</small>
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

                    <button type="submit" class="btn btn-primary">Simpan User</button>
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
