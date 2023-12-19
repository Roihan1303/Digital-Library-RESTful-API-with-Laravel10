<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Digital Library</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/uinma_lib.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/uinma_lib.png') }}" alt="">
                <span class="d-none d-lg-block">Digital Library</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <!-- KERANJANG -->
                @if (session('role') == 'Mahasiswa')
                    <li class="nav-item dropdown">

                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-cart4"></i>
                            <span class="badge bg-danger badge-number">{{ count($cartData) }}</span>
                        </a><!-- End Messages Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                            <li class="dropdown-header">
                                Keranjang | {{ session('username') }}
                                <a href="{{ route('detailKeranjang') }}"><span
                                        class="badge rounded-pill bg-primary p-2 ms-2">View
                                        all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @foreach ($cartData as $cart)
                                <form action="{{ route('deleteCart', ['keranjangId' => $cart['id']]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <li class="message-item">
                                        <a href="">
                                            <img src="{{ $cart['buku']['cover'] }}">
                                            <div>
                                                <h4>{{ $cart['buku']['judul'] }}</h4>
                                                <p>{{ $cart['buku']['kategori'] }} | Jumlah : {{ $cart['jumlah'] }}
                                                </p>
                                            </div>
                                            <button type="submit" class="btn-close" style="font-size: 30px;"></button>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                </form>
                            @endforeach

                            <li class="dropdown-footer">
                                <a href="{{ route('detailKeranjang') }}"><span class="btn btn-primary p-2 ms-2">Pinjam
                                        Buku</span></a>
                            </li>

                        </ul><!-- End Messages Dropdown Items -->

                    </li>
                @endif

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ session('name') }} </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ session('name') }}</h6>
                            <span>{{ session('role') }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            {{-- MAHASISWA --}}
            @if (session('role') == 'Mahasiswa')
                <li class="nav-heading">Home</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('book') }}">
                        <i class="bi bi-book"></i>
                        <span>Book</span>
                    </a>
                </li><!-- End Book Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('ebook') }}">
                        <i class="bi bi-book"></i>
                        <span>E-Book</span>
                    </a>
                </li><!-- End E-Book Nav -->

                <li class="nav-heading">Peminjaman</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('listPeminjaman') }}">
                        <i class="bi bi-book"></i>
                        <span>List Peminjaman</span>
                    </a>
                </li><!-- End List Peminjaman Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('historiPeminjaman') }}">
                        <i class="bi bi-book"></i>
                        <span>Histori Peminjaman</span>
                    </a>
                </li><!-- End Histori Peminjaman Nav -->

                <li class="nav-heading">Users</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('profile') }}">
                        <i class="bi bi-book"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <!-- End Profile Nav -->
            @else
                {{-- PETUGAS --}}
                <li class="nav-heading">Home</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('dataBuku') }}">
                        <i class="bi bi-book"></i>
                        <span>Data Buku</span>
                    </a>
                </li><!-- End Data Buku Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('dataMahasiswa') }}">
                        <i class="bi bi-book"></i>
                        <span>Data Mahasiswa</span>
                    </a>
                </li><!-- End Data Buku Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('laporanPeminjaman') }}">
                        <i class="bi bi-journal-text"></i>
                        <span>Laporan Peminjaman</span>
                    </a>
                </li><!-- End Laporan Peminjaman Nav -->

                <li class="nav-heading">Users</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('profile') }}">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li><!-- End Profile Page Nav -->
            @endif
        </ul>

    </aside><!-- End Sidebar-->

    @yield('content')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        const toastLiveExample = document.getElementById('liveToast')
        const toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
    </script>
</body>

</html>
