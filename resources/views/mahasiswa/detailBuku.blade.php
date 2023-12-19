<?php
// $sql = "SELECT * FROM buku LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori WHERE kode_buku='" . $_GET['kode'] . "'";
// $query = $koneksi->query($sql);
// $data = mysqli_fetch_array($query);

// $tgl_pinjam = date('Y-m-d');
// $timestampForGivenDate = strtotime($tgl_pinjam);
// $batas = date('Y-m-d', strtotime('+7 day', $timestampForGivenDate));
?>
@extends('header')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Buku</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">{{ $data['jenis'] }}</li>
                    <li class="breadcrumb-item">Detail Buku</li>
                    <li class="breadcrumb-item active">{{ $data['judul'] }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="{{ $data['cover'] }}" class="rounded-circle">
                            <h2 style="text-align: center;">{{ $data['judul'] }}</h2>
                            <h3>{{ $data['jenis'] }}</h3>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#book-overview">Overview</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <!-- Book Profile Form -->
                                <div class="tab-pane fade show active profile-overview" id="book-overview">
                                    <h5 class="card-title">About Book</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Judul</div>
                                        <div class="col-lg-9 col-md-8">{{ $data['judul'] }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Penulis</div>
                                        <div class="col-lg-9 col-md-8">{{ $data['penulis'] }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Halaman</div>
                                        <div class="col-lg-9 col-md-8">{{ $data['halaman'] }} Halaman</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Jenis Buku</div>
                                        <div class="col-lg-9 col-md-8">{{ $data['jenis'] }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Kategori</div>
                                        <div class="col-lg-9 col-md-8">{{ $data['kategori'] }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Stok</div>
                                        <div class="col-lg-9 col-md-8">{{ $data['stok'] }}</div>
                                    </div>

                                    <p class="small fst-italic">{{ $data['deskripsi'] }}</p>
                                    <div class="text-center">
                                        @if ($data['jenis'] == 'Book')
                                            <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#pinjamBuku">Pinjam</button>
                                            <div class="modal fade" id="pinjamBuku" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Peminjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="row g-3" action="{{ route('tambahKeranjang') }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="userId"
                                                                    value="{{ session('userId') }}">
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name="username"
                                                                            value="{{ session('username') }}" readonly>
                                                                        <label>NIM</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name="nama"
                                                                            value="{{ session('name') }}" readonly>
                                                                        <label>Nama</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name="bukuId"
                                                                            value="{{ $data['id'] }}" hidden>
                                                                        <input class="form-control" name="stok"
                                                                            value="{{ $data['stok'] }}" hidden>
                                                                        <input class="form-control" name=""
                                                                            value="{{ $data['judul'] }}" readonly>
                                                                        <label>Judul Buku</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name=""
                                                                            value="{{ $data['kategori'] }}" readonly>
                                                                        <label>Kategori Buku</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-floating">
                                                                        <input type="number" class="form-control"
                                                                            name="jumlah" required
                                                                            placeholder="Jumalah yang dipinjam">
                                                                        <label for="floatingName">Jumlah</label>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Tambah Ke
                                                                Keranjang</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Vertically centered Modal-->
                                        @else
                                            <a href="{{ route('downloadPDF', ['kode_buku' => $data['kode_buku']]) }}"><button
                                                    type="button" class="btn btn-success">Download Book</button></a>
                                        @endif

                                    </div>
                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>
                </div>
            </div>

            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                @if (session('failed'))
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </section>

    </main><!-- End #main -->
@endsection
