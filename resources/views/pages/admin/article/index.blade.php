@extends('layouts.admin')

@section('title')
    Admin Artikel
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Buat Artikel</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Artikel</h6>
            </div>

            <div class="card-body">
                <div class="mb-4 d-flex justify-content-between">
                    <a class="bg-primary py-2 px-4 rounded-lg text-white text-decoration-none"
                        href="{{ route('artikel.create') }}">
                        Tambah Artikel
                    </a>
                    <form method="GET" action="{{ route('artikel.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Cari artikel..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ml-2">Cari</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 10%">Tumbnail</th>
                                <th style="width: 15%">Judul</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Kontributor</th>
                                <th style="width: 10%">Editor</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td style="width: 5%">{{ $data->firstItem() + $key }}</td>
                                    <td style="width: 10">
                                        <img src="{{ Storage::url($item->image) }}" alt=""
                                            style="width: 100%;  object-fit: cover;">
                                    </td>
                                    <td style="width: 20%">{{ $item->title }}</td>
                                    <td style="width: 10%">
                                        <span
                                            class="badge py-2 px-4 text-white
                                    @if ($item->status == 'draft') bg-warning
                                    @elseif ($item->status == 'published') bg-success
                                    @elseif ($item->status == 'rejected') bg-danger @endif
                                ">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td style="width: 10%">{{ $item->articleContributor->name }}</td>
                                    <td style="width: 10%">{{ $item->articleEditor->name }}</td>
                                    <td style="width: 20%">
                                        <div class="row ml-1">
                                            @if ($item->status == 'draft' || $item->status == 'published' && auth()->user()->hasRole(['SUPERADMIN', 'ADMIN']))
                                                <div>
                                                    <a href="{{ route('artikel.edit', $item->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                </div>
                                                @endif
                                                <div class="ml-2">
                                                    <button type="button" class="btn btn-danger btn-delete"
                                                        data-id="{{ $item->id }}">Hapus</button>
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('artikel.destroy', $item->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listener untuk tombol hapus
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const form = document.getElementById(`delete-form-${id}`);

                    // Tampilkan konfirmasi SweetAlert
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit form jika dikonfirmasi
                        }
                    });
                });
            });
        });
    </script>
@endpush
