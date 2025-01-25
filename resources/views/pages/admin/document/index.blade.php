@extends('layouts.admin')

@section('title')
    Admin Dokumen Artikel
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Dokumen</h6>
            </div>

            <div class="card-body">
                <div class="mb-4 d-flex justify-content-between">
                    <a class="bg-primary py-2 px-4 rounded-lg text-white text-decoration-none"
                        href="{{ route('dokumen.create') }}">
                        Tambah Dokumen
                    </a>
                    <form method="GET" action="{{ route('dokumen.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Cari dokumen..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ml-2">Cari</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 30%">Nama Dokumen</th>
                                <th style="width: 20%">Link</th>
                                <th style="width: 15%">File</th>
                                <th style="width: 25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td style="width: 5%">{{ $data->firstItem() + $key ?? 1 }}</td>
                                    <td style="width: 30%">{{ $item->name }}</td>
                                    <td style="width: 20%">
                                        @if ($item->link)
                                            <a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="width: 15%">
                                        @if ($item->file)
                                            <a href="{{ asset('storage/' . $item->file) }}" target="_blank">
                                                <i class="fas fa-file-alt fa-2x"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="width: 25%">
                                        <div class="row ml-1">
                                            <div>
                                                <a href="{{ route('dokumen.edit', $item->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                            </div>
                                            <div class="ml-2">
                                                <button type="button" class="btn btn-danger btn-delete"
                                                    data-id="{{ $item->id }}">Hapus</button>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('dokumen.destroy', $item->id) }}" method="POST"
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
                                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
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
