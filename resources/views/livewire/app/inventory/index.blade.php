<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Master Data Inventory</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Inventory Master</li>
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

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Barang</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bx-box"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$itemCount}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Item</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Kategori Barang</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bxs-joystick-button"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{count($categoryList)}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Kategori</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

        </section>

        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Kategori</h5>
                                    <p>Kategori digunakan untuk mengelompokkan jenis barang di inventory. Kelola dan
                                        tambah
                                        kategori barang untuk mempermudah klasifikasi stok.</p>
                                    <a wire:navigate href="{{route('appCategoryRegisterPage')}}" class="btn btn-primary"><i class="bi bi-plus-square me-2"></i>Tambah Kategori</a>
                                    <hr>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Kategori</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categoryList as $kategori)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{$kategori['nama_kategori']}}</td>
                                                <td>
                                                    <a wire:navigate href="{{route('appCategoryDetailPage', ['categoryId' => $kategori['id']])}}" type="button" class="btn btn-success btn-sm">
                                                        <i class="bi bi-eye-fill"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Barang</h5>
                                    <p>Tampilkan barang dalam inventory lengkap dengan informasi detail seperti
                                        nama, dan kategori</p>

                                    <a href="{{route('appShowAllItemsPage')}}" wire:navigate class="btn btn-primary">
                                        <i class="bi bi-card-list me-2"></i>Lihat Semua Barang
                                    </a>

                                    <a href="{{route('appFilteredItemsPage')}}" wire:navigate class="btn btn-success"><i class="bx bx-filter-alt me-2"></i>Filter Berdasakan Kategori</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Daftar Satuan</h5>
                                    <p>Menampilkan seluruh jenis satuan yang digunakan dalam pencatatan barang.</p>
                                    <a href="{{route('appUnitRegisterPage')}}" class="btn btn-primary"><i class="bi bi-plus-square me-2"></i>Tambah Satuan</a>
                                    <hr>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Satuan</th>
                                                <th scope="col">Satuan</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($satuanBarangList as $satuanBarang)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{$satuanBarang['nama_satuan']}}</td>
                                                <td>{{$satuanBarang['kode_satuan']}}</td>
                                                <td>
                                                    <a href="{{route('appUnitDetailPage', ['unitId' => $satuanBarang['id']])}}" wire:navigate class="btn btn-success btn-sm">
                                                        <i class="bi bi-eye-fill"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>


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