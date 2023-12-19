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
                    <li class="breadcrumb-item">Data Buku</li>
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
                                    @if ($data['jenis'] == 'E-Book')
                                        <form action="{{ route('delete', ['kode_buku' => $data['kode_buku']]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-danger">Delete Book</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                    <!-- Edit Book -->
                    @if ($data['jenis'] == 'Book')
                        <div class="card">
                            <div class="card-body pt-3">
                                <!-- Bordered Tabs -->
                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#book-edit">Edit
                                            Book</button>
                                    </li>
                                </ul>
                                <div class="tab-content pt-2">
                                    <!-- Book Profile Form -->
                                    <div class="tab-pane fade show active profile-overview" id="book-edit">
                                        <h5 class="card-title">Update Buku</h5>
                                        <form action="{{ route('update', ['kode_buku' => $data['kode_buku']]) }}"
                                            method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Stok</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="stok" type="number" class="form-control"
                                                        value="{{ $data['stok'] }}">
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Delete
                                                    Book</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                        <form id="delete-form"
                                            action="{{ route('delete', ['kode_buku' => $data['kode_buku']]) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div><!-- End Bordered Tabs -->
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <script>
        const toastLiveExample = document.getElementById('liveToast')
        const toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
    </script>
@endsection
