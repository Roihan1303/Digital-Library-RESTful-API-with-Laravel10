<?php
$tgl_pinjam = $peminjaman['tgl_pinjam']; // Tanggal pinjam
$batas_pinjam = $peminjaman['batas_pinjam']; // Tanggal batas pinjam
$tgl_kembali = $peminjaman['tgl_kembali']; // Tanggal kembali saat ini

$tgl_pinjamObj = new DateTime($tgl_pinjam);
$batas_pinjamObj = new DateTime($batas_pinjam);
$tgl_kembaliObj = new DateTime($tgl_kembali);

$selisih = $tgl_kembaliObj->diff($tgl_pinjamObj);

$jumlahHari = $selisih->days;

$jumlahHariTerlambat = max(0, $jumlahHari - $batas_pinjamObj->diff($tgl_pinjamObj)->days);

$denda = $jumlahHariTerlambat * 2000;
?>
@extends('header')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Peminjaman</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Peminjaman</a></li>
                    <li class="breadcrumb-item"><a href="">Detail Peminjaman</a></li>
                    <li class="breadcrumb-item active">{{ $peminjaman['kode_pinjam'] }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="col-12">
                <div class="card top-selling overflow-auto">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Detail Peminjaman <span>| {{ $peminjaman['users']['username'] }}</span></h5>
                        <form action="{{ route('pengembalian', ['pinjamId' => $peminjaman['id']]) }}" method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" name="nim"
                                            value="{{ $peminjaman['users']['username'] }}" readonly>
                                        <label>NIM</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" name="namaMhs"
                                            value="{{ $peminjaman['users']['name'] }}" readonly>
                                        <label>Nama</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Buku</th>
                                        <th scope="col">Judul Buku</th>
                                        <th scope="col">Kategori Buku</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjaman['detail_peminjaman'] as $data)
                                        <tr>
                                            <input type="text" name="bukuId[]" value="{{ $data['buku']['id'] }}" hidden>
                                            <input type="number" name="jumlah[]" value="{{ $data['jumlah'] }}" hidden>
                                            <th scope="row"><img src="{{ $data['buku']['cover'] }}" alt="">
                                            </th>
                                            <td><span class="text-primary fw-bold">{{ $data['buku']['judul'] }}</span>
                                            </td>
                                            <td>{{ $data['buku']['kategori'] }}</td>
                                            <td class="fw-bold">{{ $data['jumlah'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input class="form-control" name="tgl_pinjam" value="<?= $tgl_pinjam ?>" readonly>
                                        <label>Tanggal Pinjam</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input class="form-control" name="batas_pinjam" value="<?= $batas_pinjam ?>"
                                            readonly>
                                        <label>Batas Pinjam</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input class="form-control" name="tgl_kembali" value="<?= $tgl_kembali ?>" readonly>
                                        <label>Tanggal Kembali</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="denda" value="<?= $denda ?>"
                                            readonly>
                                        <label>Denda</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" name="status" value="{{ $peminjaman['status'] }}"
                                            readonly>
                                        <label>Status</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input class="form-control" name="namaPetugas" value="Petugas Perpustakaan"
                                            readonly>
                                        <label for="floatingName">Nama Petugas</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="text-center">
                                @if (session('role') == 'Petugas')
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                @else
                                    <button type="button" onclick="window.print()"
                                        class="btn btn-success">Download</button>
                                @endif
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div><!-- End Recent Sales -->
        </section>

    </main><!-- End #main -->
@endsection
