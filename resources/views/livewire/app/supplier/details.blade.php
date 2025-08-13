<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Informasi Akun</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Supplier Master</li>
                    <li class="breadcrumb-item active">Detail</li>
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

            <a href="{{route('appSupplierIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-lg-8">

                    <div class="card">

                        <div class="row">
                            <div class="col-4">
                                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                    <img width="200" height="200"
                                        src="{{$logo_img}}"
                                        alt="Profile" class="img-fluid">
                                    <h3>{{$supplierData['nama_supplier']}}</h3>
                                    <h4>{{$supplierData['category']['nama_kategori']}}</h4>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="card-body">
                                    <h5 class="card-title">Data Supplier</h5>
                                    <ul class="nav nav-tabs nav-tabs-bordered">

                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#tab-overview">Overview</button>
                                        </li>

                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#tab-sistem">Sistem</button>
                                        </li>

                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#tab-statistik">Statistik</button>
                                        </li>

                                    </ul>
                                    <div class="tab-content pt-2">

                                        <div class="tab-pane fade show active" id="tab-overview">
                                            <h5 class="card-title">Tentang</h5>
                                            <p class="small">{{$supplierData['tentang']}}</p>

                                            <h5 class="card-title">Detail</h5>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Negara</div>
                                                <div class="col-lg-9 col-md-8">{{$supplierData['negara']}}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Nomer Telepon</div>
                                                <div class="col-lg-9 col-md-8">+62{{$supplierData['nomer_telepon_kantor']}}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Email</div>
                                                <div class="col-lg-9 col-md-8">{{$supplierData['email_kantor']}}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Website</div>
                                                <div class="col-lg-9 col-md-8">{{$supplierData['website']}}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">NPWP</div>
                                                <div class="col-lg-9 col-md-8">{{$supplierData['npwp']}}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Alamat</div>
                                                <div class="col-lg-9 col-md-8">{{$supplierData['alamat']}}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Tanggal bergabung</div>
                                                <div class="col-lg-9 col-md-8">{{$created_at}}</div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade pt-3" id="tab-sistem">
                                            <h5 class="card-title">Akun Supplier</h5>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Nama</div>
                                                <div class="col-lg-9 col-md-8">{{$supplierData['user']['fullname']}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Email</div>
                                                <div class="col-lg-9 col-md-8">{{$supplierData['user']['email']}}</div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tab-statistik">
                                            <h5 class="card-title">Kunjungan</h5>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Terakhir Berkunjung</div>
                                                <div class="col-lg-9 col-md-8">{{$last_visit ?? '-' }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Kunjungan bulan ini</div>
                                                <div class="col-lg-9 col-md-8">{{$count_visit_log ?? '-' }} kali</div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-lg-4">

                    <div class="row">
                        <div class="col">
                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title">Barcode Supplier</h5>

                                    <img class="img-fluid img-thumbnail mx-auto d-block mb-2"
                                        src="data:image/png;base64,{{$QRbarcode}}">

                                    <div class="text-center">
                                        <a wire:click="downloadBarcode" class="btn btn-primary"><i class="bx bx-download me-1"></i>Download</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">

                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title">Ubah Data</h5>

                                    <div class="text-center">
                                        <a wire:navigate href="{{route('appSupplierEditDataPage', ['supplierId' => $supplierData['id']])}}" class="btn btn-warning"><i class="bx bxs-edit"></i>
                                            Edit Data Supplier</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>