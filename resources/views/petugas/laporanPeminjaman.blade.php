@extends('header')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Laporan Peminjaman</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Peminjaman</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            <!-- Laporan Peminjaman -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Peminjaman</h5>
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Pinjam</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">Kategori Buku</th>
                                    <th scope="col">Tanggal Peminjaman</th>
                                    <th scope="col">Batas Peminjaman</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan as $data)
                                    <tr>
                                        <td>{{ $data['kode_pinjam'] }}</td>
                                        <td>{{ $data['users']['username'] }}</td>
                                        <td>{{ $data['users']['name'] }}</td>
                                        <th>
                                            @foreach ($data['detail_peminjaman'] as $detail)
                                                {{ '• ' . $detail['buku']['judul'] }}<br>
                                            @endforeach
                                        </th>
                                        <td>
                                            @foreach ($data['detail_peminjaman'] as $detail)
                                                {{ '• ' . $detail['buku']['kategori'] }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $data['tgl_pinjam'] }}</td>
                                        <td>{{ $data['batas_pinjam'] }}</td>
                                        <td>
                                            @foreach ($data['detail_peminjaman'] as $detail)
                                                {{ '• ' . $detail['jumlah'] }}<br>
                                            @endforeach
                                        </td>
                                        @if ($data['status'] == 'Belum Kembali')
                                            <td><button type="submit" class="badge bg-danger-light text-dark">Belum
                                                    Kembali</button></td>
                                        @elseif ($data['status'] == 'Sudah Kembali')
                                            <td><button type="submit" class="badge bg-success-light text-dark">Sudah
                                                    Kembali</button></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Konfirmasi Pengembalian -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Konfirmasi Pengembalian</h5>
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Pinjam</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">Kategori Buku</th>
                                    <th scope="col">Tanggal Peminjaman</th>
                                    <th scope="col">Batas Peminjaman</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($konfirmasi as $data)
                                    <tr>
                                        <td>{{ $data['kode_pinjam'] }}</td>
                                        <td>{{ $data['users']['username'] }}</td>
                                        <td>{{ $data['users']['name'] }}</td>
                                        <td>
                                            @foreach ($data['detail_peminjaman'] as $detail)
                                                {{ '• ' . $detail['buku']['judul'] }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($data['detail_peminjaman'] as $detail)
                                                {{ '• ' . $detail['buku']['kategori'] }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $data['tgl_pinjam'] }}</td>
                                        <td>{{ $data['batas_pinjam'] }}</td>
                                        <td>
                                            @foreach ($data['detail_peminjaman'] as $detail)
                                                {{ '• ' . $detail['jumlah'] }}<br>
                                            @endforeach
                                        </td>
                                        @if ($data['status'] == 'Menunggu')
                                            <td>
                                                <button class="badge bg-warning-light text-dark">Waiting</button>
                                                <a href="{{ route('detailPeminjaman', ['pinjamId' => $data['id']]) }}"><button
                                                        class="badge bg-success-light text-dark">Detail</button></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Alert -->
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                @if (session('success'))
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </section>

    </main><!-- End #main -->
@endsection
