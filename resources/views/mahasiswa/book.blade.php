@extends('header')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Book</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Book</li>
                    <?php
                if (isset($_GET['kategori'])) { ?>
                    <li class="breadcrumb-item active">
                        <?php
                        echo $_GET['kategori'];
                        ?>
                    </li>
                    <?php
                } else { ?>
                    <li class="breadcrumb-item active">All Book</li>
                    <?php
                }
                ?>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row align-items-top">
                @foreach ($bookData as $buku)
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
                        <i class="bi bi-info-circle me-1"></i>
                        {{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </section>

    </main><!-- End #main -->
@endsection
