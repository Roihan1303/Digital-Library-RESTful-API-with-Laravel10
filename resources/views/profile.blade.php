@extends('header')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>User Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                    <li class="breadcrumb-item active">{{ $user['name'] }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor"
                                class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            <h2>{{ $user['name'] }}</h2>
                            <h3>{{ $user['role'] }}</h3>
                            <div class="social-links mt-2">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
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
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Change Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <!-- Profile Overview Form -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">About</h5>
                                    <p class="small fst-italic">Hello, My name is {{ $user['name'] }}</p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Username</div>
                                        <div class="col-lg-9 col-md-8">{{ $user['username'] }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8">{{ $user['name'] }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Major</div>
                                        <div class="col-lg-9 col-md-8">{{ $user['major'] }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $user['email'] }}</div>
                                    </div>

                                </div>

                                <!-- Profile Edit Form -->
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- FORM PETUGAS -->
                                    @if (session('role') == 'Petugas')
                                        <form action="{{ route('editProfile') }}" method="POST">
                                            @csrf
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Username</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="username" type="text" class="form-control"
                                                        value="{{ $user['username'] }}" hidden>
                                                    <input type="text" class="form-control"
                                                        value="{{ $user['username'] }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="name" type="text" class="form-control"
                                                        value="{{ $user['name'] }}" required>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    @else
                                        <!-- FORM MAHASISWA -->
                                        <form action="{{ route('editProfile') }}" method="post">
                                            @csrf
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Username</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="username" type="text" class="form-control"
                                                        value="{{ $user['username'] }}" hidden>
                                                    <input type="text" class="form-control"
                                                        value="{{ $user['username'] }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="name" type="text" class="form-control"
                                                        value="{{ $user['name'] }}" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Major</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="major" type="text" class="form-control"
                                                        value="{{ $user['major'] }}" required>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    @endif

                                </div><!-- End Profile Edit Form -->

                                <!-- Change Password Form -->
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <form action="{{ route('editProfile') }}" method="post">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="Password" class="col-md-4 col-lg-3 col-form-label">New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="password" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="repassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="repassword" type="password" class="form-control"
                                                    id="repassword" required>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form>

                                </div><!-- End Change Password Form -->

                            </div><!-- End Bordered Tabs -->
                        </div>
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
                @elseif (session('failed'))
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </section>

    </main>
@endsection
