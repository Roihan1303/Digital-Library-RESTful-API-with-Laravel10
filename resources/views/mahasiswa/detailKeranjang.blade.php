<?php
$tgl_pinjam = date('Y-m-d');
$timestampForGivenDate = strtotime($tgl_pinjam);
$batas = date('Y-m-d', strtotime('+7 day', $timestampForGivenDate));
?>
@extends('header')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Keranjang</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Peminjaman</a></li>
                    <li class="breadcrumb-item"><a href="">Keranjang</a></li>
                    <li class="breadcrumb-item active">{{ session('username') }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="col-12">
                <div class="card top-selling overflow-auto">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Keranjang <span>| {{ session('username') }}</span></h5>
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
                                <form action="{{ route('peminjaman') }}" method="post">
                                    @csrf
                                    @foreach ($cartData as $cart)
                                        <tr>
                                            <input type="text" name="userId" value="{{ session('userId') }}" hidden>
                                            <input type="text" name="bukuId[]" value="{{ $cart['buku']['id'] }}" hidden>
                                            <input type="number" name="jumlah[]" value="{{ $cart['jumlah'] }}" hidden>
                                            <th scope="row"><img src="{{ $cart['buku']['cover'] }}" alt=""></th>
                                            <td><span class="text-primary fw-bold">{{ $cart['buku']['judul'] }}</span></td>
                                            <td>{{ $cart['buku']['kategori'] }}</td>
                                            <td class="fw-bold">{{ $cart['jumlah'] }}</td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <input type="date" name="tgl_pinjam" value="<?= $tgl_pinjam ?>" hidden>
                                        <td colspan="5" class="text-end">Tanggal Peminjaman : <?= $tgl_pinjam ?></td>
                                    </tr>
                                    <hr>
                                    <tr>
                                        <input type="date" name="batas_pinjam" value="<?= $batas ?>" hidden>
                                        <td colspan="5" class="text-end">Tanggal Jatuh Tempo : <?= $batas ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-center"><button type="submit"
                                                class="btn btn-primary">Pinjam Buku</button></td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div><!-- End Recent Sales -->
        </section>

    </main><!-- End #main -->
@endsection
