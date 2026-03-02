<div>
    <livewire:PartialView.App.Header />
    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Hutang Pengrajin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Hutang Piutang</li>
                    <li class="breadcrumb-item active">Pengrajin</li>
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
            <a href="{{route('appHutangStatisticsPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 pt-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Pengrajin:</strong>
                                {{ $namaPengrajin }}
                            </div>

                            <div class="row g-3 mb-4 text-center">

                                <div class="col-md-4 col-12">
                                    <div class="border rounded p-3 bg-light">
                                        <small class="text-muted">Total Hutang</small>
                                        <h5 class="fw-bold text-dark mb-0">
                                            Rp {{ number_format($hutangDatas['total_hutang_pengrajin'], 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="border rounded p-3 bg-light">
                                        <small class="text-muted">Sisa Hutang</small>
                                        <h5 class="fw-bold text-danger mb-0">
                                            Rp {{ number_format($hutangDatas['total_sisa_hutang'], 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="border rounded p-3 bg-light">
                                        <small class="text-muted">Hutang Aktif</small>
                                        <h5 class="fw-bold mb-0">
                                            {{ $hutangDatas['total_hutang_active'] }}
                                        </h5>
                                    </div>
                                </div>
                                <a class="btn btn-success" wire:navigate href="{{ route('appPeminjamanBaruPage', ['pengrajinId' => $pengrajinId]) }}">
                                    <i class="bi bi-cash-coin me-1"></i>
                                    Pinjaman Baru
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle datatable">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Total Hutang</th>
                                            <th>Sisa Hutang</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($hutangDatas['data_hutang'] as $hutang)
                                        <tr>
                                            <td>
                                                Rp {{ number_format($hutang['total_hutang'], 0, ',', '.') }}
                                            </td>

                                            <td class="fw-semibold {{ (float)$hutang['sisa_hutang'] > 0 ? 'text-danger' : 'text-success' }}">
                                                @if((float)$hutang['sisa_hutang'] > 0)
                                                Rp {{ number_format($hutang['sisa_hutang'], 0, ',', '.') }}
                                                @else
                                                Lunas
                                                @endif
                                            </td>

                                            <td>
                                                @if($hutang['status'] == 'active')
                                                <span class="badge bg-danger">Active</span>
                                                @else
                                                <span class="badge bg-success">Lunas</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ \App\Helpers\IndoDateFormat::formatIndo($hutang['created_at'])}}
                                            </td>

                                            <td>
                                                <a target="_blank" href="{{ route('appHutangDetails', ['hutangId' => $hutang['id']]) }}" class="btn btn-sm btn-outline-primary w-100">Detail Hutang</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                Tidak ada data hutang
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