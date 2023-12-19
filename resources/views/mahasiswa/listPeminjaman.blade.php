@extends('header')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Peminjaman</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">List Peminjaman</a></li>
                    <li class="breadcrumb-item active">{{ session('username') }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">List Peminjaman</h5>
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Pinjam</th>
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">Kategori Buku</th>
                                    <th scope="col">Tanggal Peminjaman</th>
                                    <th scope="col">Batas Peminjaman</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peminjaman as $data)
                                    <tr>
                                        <th>{{ $data['kode_pinjam'] }}</th>
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
                                        @if ($data['status'] == 'Belum Kembali')
                                            <td>
                                                <form
                                                    action="{{ route('prosesPengembalian', ['pinjamId' => $data['id']]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="badge bg-danger-light text-dark">Kembalikan?</button>
                                                </form>

                                            </td>
                                        @elseif ($data['status'] == 'Menunggu')
                                            <td><button class="badge bg-warning-light text-dark">Waiting</button></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- End Recent Sales -->
        </section>

    </main><!-- End #main -->
@endsection
