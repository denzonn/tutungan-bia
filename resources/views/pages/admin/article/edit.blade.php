@extends('layouts.admin')

@section('title')
    Edit Artikel - Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <a href="{{ route('artikel.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body py-md-4 px-md-5">
                <div class="text-center">
                    <h1 class="h3 mb-2 text-gray-800">Silahkan Edit Artikel</h1>
                </div>
                <form action="{{ route('artikel.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Judul Artikel</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ $data->title }}" required />
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="category_article_id">Kategori Artikel</label>
                                <select name="category_article_id" id="category_article_id" class="form-control">
                                    @forelse ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $data->category_article_id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @empty
                                        <option value="">Tidak Ada Kategori</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="title">Tanggal Artikel</label>
                                <input type="date" class="form-control @error('publish_date') is-invalid @enderror"
                                    id="publish_date" name="publish_date" value="{{ $data->publish_date }}" required />
                                @error('publish_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="content">Isi Artikel</label>
                        <textarea name="content" id="editor">{!! $data->content !!}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Thumbnail Artikel</label>
                                <input type="file" name="image" class="form-control" accept=".png, .jpg, .jpeg"
                                    id="imageInput" />
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

                    @if ($data->status == 'draft' && !auth()->user()->hasRole('REPORTER'))
                        <div class="form-group">
                            <label for="status">Status Artikel</label>
                            <select name="status" id="status" class="form-control">
                                <option value="" selected>Silahkan Pilih Status</option>
                                <option value="published">Diterima</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                    @endif

                    @if ($data->status == 'published')
                        <input type="hidden" value="published" name="status">
                    @endif

                    <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                }
            })
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
