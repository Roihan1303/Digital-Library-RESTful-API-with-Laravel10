{{-- <?php
// session_start();
// if ($_SESSION['role'] != 'Mahasiswa') {
//     header('location:dataBuku.php?msg=denied-access');
// }

// if (isset($_GET['kategori'])) {
//     $kategori = $_GET['kategori'];
//     $sql2 = "SELECT * FROM buku LEFT JOIN file ON buku.kode_buku=file.kode_buku
//                                 LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori
//                                 WHERE kategori='$kategori' AND tipe='image/jpeg' AND jenis='Book'";
//     $query2 = $koneksi->query($sql2);
// } else {
//     $sql = "SELECT * FROM buku LEFT JOIN file ON buku.kode_buku=file.kode_buku WHERE tipe='image/jpeg' AND jenis='Book'";
//     $query = $koneksi->query($sql);
// }
?> --}}
@extends('header')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>E-Book</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">E-Book</li>
                    <li class="breadcrumb-item active">All Book</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row align-items-top">
                @foreach ($ebookData as $buku)
                    <div class="col-lg-3">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <a href="{{ route('detailBuku', ['kode_buku' => $buku['kode_buku']]) }}"><img
                                    src="{{ $buku['cover'] }}" class="card-img-top" alt="..." height="250"></a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $buku['judul'] }}</h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>
                @endforeach
            </div>

            {{-- <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'denied-access') { ?>
            <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <i class="bi bi-info-circle me-1"></i>
                Akses Ditolak
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
                } elseif ($_GET['msg'] == 'peminjaman-failed') { ?>
            <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <i class="bi bi-info-circle me-1"></i>
                Peminjaman Buku Gagal
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
                } elseif ($_GET['msg'] == 'peminjaman-success') { ?>
            <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <i class="bi bi-info-circle me-1"></i>
                Peminjaman Buku Berhasil
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
                }
            } else { ?>
            <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <i class="bi bi-info-circle me-1"></i>
                Selamat Datang <?= $_SESSION['nama'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            }
            ?>
        </div> --}}
        </section>

    </main><!-- End #main -->
    <script>
        const toastLiveExample = document.getElementById('liveToast')
        const toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
    </script>
@endsection
