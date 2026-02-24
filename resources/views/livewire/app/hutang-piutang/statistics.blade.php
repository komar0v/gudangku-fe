<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Statistik Hutang Piutang</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Hutang Piutang</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
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

            <div class="row g-3 mb-4">

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                <i class="bi bi-file-earmark-text text-warning fs-3"></i>
                            </div>

                            <div>
                                <small class="text-muted">Hutang Aktif</small>
                                <h4 class="fw-bold mb-0">
                                    {{ count($dataHutangs['detail']) }}
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                <i class="bi bi-cash-stack text-danger fs-3"></i>
                            </div>

                            <div>
                                <small class="text-muted">Total Terhutang</small>
                                <h4 class="fw-bold mb-0 text-danger">
                                    Rp {{ number_format($dataHutangs['total_terhutang'], 0, ',', '.') }}
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="bi bi-people text-primary fs-3"></i>
                            </div>

                            <div>
                                <small class="text-muted">Pengrajin Berhutang</small>
                                <h4 class="fw-bold mb-0">
                                    {{ $dataHutangs['total_pengrajin_ngutang'] }} Orang
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <a href="{{route('appScanHutangPengrajinPage')}}">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">

                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <i class="bi bi-upc-scan text-success fs-3"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-0">Scan Barcode Pengrajin</h4>
                            </div>

                        </div>
                    </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 pt-4">
                        <div class="card-body">

                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-list-ul me-2"></i>
                                Daftar Hutang Aktif
                            </h5>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle datatable">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Pengrajin</th>
                                            <th>Alamat</th>
                                            <th>Total Hutang</th>
                                            <th>Sisa Hutang</th>
                                            <th>Tanggal</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($dataHutangs['detail'] as $item)
                                        <tr>
                                            <td class="fw-semibold">
                                                {{ $item['pengrajin']['nama_pengrajin'] }}
                                            </td>

                                            <td>
                                                {{ $item['pengrajin']['alamat'] }}
                                            </td>

                                            <td class="text-danger fw-semibold">
                                                Rp {{ number_format($item['total_hutang'], 0, ',', '.') }}
                                            </td>

                                            <td class="text-danger">
                                                Rp {{ number_format($item['sisa_hutang'], 0, ',', '.') }}
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($item['created_at'])->format('d M Y') }}
                                            </td>

                                            <td>
                                                <a target="_blank" href="{{ route('appHutangDetails', ['hutangId' => $item['id']]) }}" class="btn btn-sm btn-outline-primary w-100">Detail Hutang</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                Tidak ada hutang aktif
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </section>

    </main><!-- End #main -->
    <livewire:PartialView.App.Footer />
</div>