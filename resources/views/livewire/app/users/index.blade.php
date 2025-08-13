<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Kelola Pengguna</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-4">
                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">Supplier</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$countSupplier}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Akun supplier</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card info-card">

                        <div class="card-body">
                            <h5 class="card-title">Admin</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center bg-primary text-white justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$countAdmin}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Akun Admin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card info-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Pengguna</h5>


                            <div class="row">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center bg-success text-white justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$countTotalUser}}</h6>
                                            <span class="text-muted small pt-2 ps-1">Pengguna terdaftar</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center">

                                        <a wire:navigate href="{{route('appRegisterUserPage')}}" class="btn btn-success"><i class="bi bi-person-plus-fill me-1"></i>Register Akun Baru</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Semua Pengguna</h5>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>
                                            Nama Lengkap
                                        </th>
                                        <th>Email</th>
                                        <th>Tipe Akun</th>
                                        <th>Tanggal Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($accountList['data'] as $dataAccount)
                                    <tr>
                                        <td>{{$dataAccount['fullname']}}</td>
                                        <td>{{$dataAccount['email']}}</td>
                                        <td>{{$dataAccount['role']['role_name']}}</td>
                                        <td>{{substr($dataAccount['created_at'], 0, 10)}}</td>
                                        <td>
                                            @if($dataAccount['id'] === $currentUser['id'])
                                            <a wire:navigate href="{{route('accountInfoPage')}}" class="btn btn-info btn-sm">
                                                <i class="bi bi-arrow-up-right me-1"></i>My account
                                            </a>
                                            @else
                                            <a wire:navigate href="{{ route('appDetailUserPage', ['accountId' => $dataAccount['id']]) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>