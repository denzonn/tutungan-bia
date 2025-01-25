@extends('layouts.admin')

@section('title')
    Admin User
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Buat User</h1>
        {{-- <p class="mb-4">Bagikan informasi terbaru dengan pembaca Anda. Gunakan editor di bawah untuk menulis User yang
            menarik dan mudah diakses.</p> --}}

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
            </div>

            <div class="card-body">
                <div class="mb-4 d-flex justify-content-between">
                    <a class="bg-primary py-2 px-4 rounded-lg text-white text-decoration-none"
                        href="{{ route('user.create') }}">
                        Tambah User
                    </a>
                    <form method="GET" action="{{ route('user.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Cari User..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary ml-2">Cari</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Foto</th>
                                <th style="width: 20%">Email</th>
                                <th style="width: 15%">Role</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key => $item)
                                <tr>
                                    <td style="width: 5%">{{ $data->firstItem() + $key }}</td>
                                    <td style="width: 15%">
                                        <img src="{{ Storage::url($item->profile_photo) }}" alt=""
                                            style="width: 100%;  object-fit: cover;">
                                    </td>
                                    <td style="width: 20%">{{ $item->email }}</td>
                                    <td style="width: 15%">
                                        @if ($item->getRoleNames()->isNotEmpty())
                                            @foreach ($item->getRoleNames() as $role)
                                                <span
                                                    class="badge py-2 px-4 text-white @if ($role == 'SUPERADMIN') bg-primary
                                        @elseif ($role == 'ADMIN') bg-success
                                        @elseif ($role == 'CONTRIBUTOR') bg-danger @endif">{{ ucfirst($role) }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Tidak ada role</span>
                                        @endif
                                        <span
                                            class="badge py-2 px-4 text-white
                                        
                                    ">
                                        </span>
                                    </td>
                                    <td style="width: 20%">
                                        <div class="row ml-1">
                                            <div>
                                                <a href="{{ route('user.edit', $item->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                            </div>
                                            <div class="ml-2">
                                                <button type="button" class="btn btn-danger btn-delete"
                                                    data-id="{{ $item->id }}">Hapus</button>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('user.destroy', $item->id) }}" method="POST"
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
                    <div class="d-flex justify-content-end mt-4">
                        {{ $data->appends(request()->query())->links() }}
                    </div>
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
