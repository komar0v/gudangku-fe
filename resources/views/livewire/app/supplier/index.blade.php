<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Master Data Pengrajin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Pengrajin Master</li>
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
                            <h5 class="card-title">Total Pengrajin</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$countSupplier}}</h6>
                                    <span class="text-muted small pt-2 ps-1">Pengrajin terdaftar</span>
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
                                    <h5 class="card-title">Pengrajin Terbaru</h5>
                                    <p>Menampilkan daftar pengrajin yang baru saja ditambahkan ke dalam sistem.</p>

                                    <hr>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Pengrajin</th>
                                                <th scope="col">Tanggal Bergabung</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentlyAddSuppliers as $index => $supplier)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $supplier['nama_pengrajin'] }}</td>
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
                                    <h5 class="card-title">Kelola Data Pengrajin</h5>
                                    <p>Kelola data pengrajin secara lengkap dan mudah dalam satu tempat.</p>

                                    <div class="text-center">
                                        <a wire:navigate href="{{route('appRegisterSupplierPage')}}" class="btn btn-primary"><i class="bi bi-plus-square me-1"></i>Tambah Pengrajin</a>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#basicModal"
                                            class="btn btn-success"><i class="bi bi-search"></i> Cari Pengrajin</button>

                                        <div class="modal fade" id="basicModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Cari Pengrajin</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form wire:submit.prevent="searchSupplier" class="row g-3">
                                                        <div class="modal-body">
                                                            <p>Cari berdasarkan nomer WhatsApp, atau nama pengrajin</p>

                                                            <div class="col-12 mb-2">
                                                                <input wire:model="searchQuery" type="text" class="form-control" placeholder="Cari Pengrajin">
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
                                    <h5 class="card-title">Lihat Semua Data Pengrajin</h5>
                                    <p>Tampilkan semua pengrajin yang terdaftar dalam sistem.</p>

                                    <a href="{{route('appShowAllSupplierPage')}}"
                                        class="btn btn-primary"><i class="bi bi-card-list"></i> Lihat
                                        Semua Pengrajin</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Cari pengrajin dengan barcode</h5>
                                    <p>Cari data pengrajin menggunakan scan barcode.</p>

                                    <a href="{{route('appSupplierSearchByBarcodePage')}}" class="btn btn-primary"><i class="bx bx-barcode-reader me-1"></i>Scan Barcode Pengrajin</a>
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