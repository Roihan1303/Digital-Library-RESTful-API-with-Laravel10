@extends('header')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Mahasiswa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Data Mahasiswa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Data Mahasiswa</h5>

                        <!-- Basic Modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#tambahMahasiswa">
                            Tambah Mahasiswa
                        </button>
                        <div class="modal fade" id="tambahMahasiswa" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Mahasiswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('tambahMahasiswa') }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">NIM</label>
                                                <div class="col">
                                                    <input type="text" name="username" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                                <div class="col">
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Password</label>
                                                <div class="col">
                                                    <input type="password" name="password" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Ulangi Password</label>
                                                <div class="col">
                                                    <input type="password" name="repassword" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Email</label>
                                                <div class="col">
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Jurusan</label>
                                                <div class="col">
                                                    <input type="text" name="major" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div><!-- End Basic Modal-->

                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jurusan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataMahasiswa as $mhs)
                                    <tr>
                                        <td>{{ $mhs['username'] }}</td>
                                        <td>{{ $mhs['name'] }}</td>
                                        <td>{{ $mhs['major'] }}</td>
                                        <td><a href="{{ route('detailMahasiswa', ['id' => $mhs['id']]) }}"><span
                                                    class="badge bg-success">Info</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- End Recent Sales -->

            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                @if (session('success'))
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('failed'))
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
