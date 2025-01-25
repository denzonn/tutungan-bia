<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    {{-- Style --}}
    @stack('prepend-style')
    @include('includes.admin.style')
    @stack('addon-style')

</head>

<body id="page-top">

    <!-- Page Content -->
    <div id="wrapper">

        @include('includes.admin.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                @include('includes.admin.navbar')

                @yield('content')

                @include('includes.admin.footer')
            </div>
        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    {{-- @include('includes.footer') --}}

    {{-- Script --}}
    @stack('prepend-script')
    @include('includes.admin.script')
    @stack('addon-script')

    @if (session('toast_success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: 'success',
                title: "{{ session('toast_success') }}"
            });
        </script>
    @endif

</body>

</html>
