<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Master Data Supplier</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Supplier Master</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            @if(session('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-4">

                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">Total Supplier</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$countSupplier}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Supplier terdaftar</span>
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
                                    <h5 class="card-title">Supplier Terbaru</h5>
                                    <p>Menampilkan daftar supplier yang baru saja ditambahkan ke dalam sistem.</p>

                                    <hr>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Supplier</th>
                                                <th scope="col">Tanggal Bergabung</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentlyAddSuppliers as $index => $supplier)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $supplier['nama_supplier'] }}</td>
                                                <td>{{ $supplier['created_at'] }}</td>
                                                <td><a wire:navigate href="{{ route('appSupplierDetailPage', ['supplierId' => $supplier['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a></td>
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
                                    <h5 class="card-title">Kelola Data Supplier</h5>
                                    <p>Kelola data supplier secara lengkap dan mudah dalam satu tempat.</p>

                                    <div class="text-center">
                                        <a wire:navigate href="{{route('appRegisterSupplierPage')}}" class="btn btn-primary"><i class="bi bi-plus-square me-1"></i>Tambah Supplier</a>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#basicModal"
                                            class="btn btn-success"><i class="bi bi-search"></i> Cari Supplier</button>

                                        <div class="modal fade" id="basicModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Cari Supplier</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form wire:submit.prevent="searchSupplier" class="row g-3">
                                                        <div class="modal-body">
                                                            <p>Cari supplier berdasarkan nomer telepon, nama, atau email</p>

                                                            <div class="col-12 mb-2">
                                                                <input wire:model="searchQuery" type="text" class="form-control" placeholder="Cari Supplier">
                                                            </div>
                                                            <button type="submit" class="btn btn-success">Cari <i class="bi bi-search"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Semua Data Supplier</h5>
                                    <p>Tampilkan semua supplier yang terdaftar dalam sistem.</p>

                                    <a href="{{route('appShowAllSupplierPage')}}"
                                        class="btn btn-primary"><i class="bi bi-card-list"></i> Lihat
                                        Semua Supplier</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Cari supplier dengan barcode</h5>
                                    <p>Cari data supplier menggunakan scan barcode.</p>

                                    <a href="{{route('appSupplierSearchByBarcodePage')}}" class="btn btn-primary"><i class="bx bx-barcode-reader"></i> Cari Supplier</a>
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