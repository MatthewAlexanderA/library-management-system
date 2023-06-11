<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome, {{ Auth::user()->username }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    {{-- Data Table --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/67b6ece322.js" crossorigin="anonymous"></script>

    <!-- CKeditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>

</head>

<body class="hold-transition sidebar-mini">
    @include('sweetalert::alert')

    @php
        use App\Models\Borrow;

        $verif_notif = Borrow::where('status', 'requested')->count();
        $out_notif = Borrow::where('must_return_date', '<=', date('Y-m-d'))->where('status', 'borrowed')->count();
        $member_out_notif = Borrow::where('must_return_date', '<=', date('Y-m-d'))->where('status', 'borrowed')->where('member_id', Auth::user()->id)->count();
    @endphp

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <div class="ml-3"><b>@yield('title')</b></div>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i> {{ Auth::user()->username }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="text-center">
                            <i class="fa fa-user"></i> <br>
                            {{ Auth::user()->username }} <br>
                            {{ Auth::user()->role }}
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('index') }}" class="dropdown-item">Home</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('setting.index') }}" class="dropdown-item">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <form action="/logout" method="post">
                            @csrf
                            <button style="border: 0; background-color: white;" type="submit" class="dropdown-item"
                                aria-current="page">Logout</button>
                        </form>
                    </div>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info" style="color: white;">
                        <b>Back</b>End
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link @yield('dashboard')">
                                <i class="fa-solid fa-gauge-high"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        @if (Auth::user()->role != 'member')

                        <li class="nav-header">
                            Staff
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('book.index') }}" class="nav-link @yield('book')">
                                <i class="fa-solid fa-book"></i>
                                <p>Book</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('verify') }}" class="nav-link @yield('verify')">
                                <i class="fa-solid fa-check-to-slot"></i>
                                <p>
                                    Verify
                                    @if ($verif_notif)
                                        <span class="right badge badge-danger">{{ $verif_notif }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('return-book') }}" class="nav-link @yield('return-book')">
                                <i class="fa-solid fa-arrow-left"></i>
                                <p>Return</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('request-history') }}" class="nav-link @yield('request-history')">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <p>History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('out-off-date') }}" class="nav-link @yield('out-off-date')">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <p>
                                    Out Off Date 
                                    @if ($out_notif)
                                        <span class="right badge badge-danger">{{ $out_notif }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        @endif

                        @if (Auth::user()->role == 'member')

                        <li class="nav-header">
                            Member
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('book-list') }}" class="nav-link @yield('book-list')">
                                <i class="fa-solid fa-book"></i>
                                <p>Book List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('history') }}" class="nav-link @yield('history')">
                                <i class="fa-solid fa-list"></i>
                                <p>
                                    History
                                    @if ($member_out_notif)
                                        <span class="right badge badge-danger">{{ $member_out_notif }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                            
                        @endif

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div id="content">
                <br>
                <div class="container">

                    <section class="content">
                        @yield('content')
                    </section>

                </div>
            </div>

        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Created by <a target="_blank" href="https://github.com/MatthewAlexanderA"> Matthew Alexander</a></b>
            </div>
            <strong>2023 &copy; Library Management System.</strong>
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });

    </script>

    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

    </script>

    <script>
        $(function () {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

    </script>

    <script>
        document.addEventListener('trix-file-accept', function (e) {
            e.preventDefault();
        })

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

    <!-- JAVASCRIPT -->
    <script src="../../assets/home/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unicons.iconscout.com/release/v4.0.0/script/monochrome/bundle.js"></script>

</body>

</html>
