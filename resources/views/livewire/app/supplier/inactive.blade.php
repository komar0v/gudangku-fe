<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Pengrajin Libur</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Pengrajin Master</li>
                    <li class="breadcrumb-item active">Inactive</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <a href="{{route('appSupplierIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title mb-3">
                                <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                                Pengrajin Libur/Tidak Aktif
                            </h5>

                            <!-- SUMMARY -->
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="border rounded p-2 text-center">
                                        <small class="text-muted d-block">Tidak Ada Pengambilan</small>
                                        <h6 class="fw-bold mb-0">
                                            > {{ $inactivePengrajin['days'] }} Hari
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2 text-center">
                                        <small class="text-muted d-block">Total Tidak Aktif</small>
                                        <h6 class="fw-bold mb-0 text-danger">
                                            {{ $inactivePengrajin['total_pengrajin_inactive'] }} Orang
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- LIST -->
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle datatable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Terakhir Ambil</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inactivePengrajin['data'] as $item)
                                        <tr>

                                            <!-- Nama -->
                                            <td class="fw-semibold">
                                                {{ $item['nama_pengrajin'] }}
                                            </td>

                                            <!-- Alamat -->
                                            <td>
                                                <small class="text-muted">
                                                    {{ $item['alamat'] }}
                                                </small>
                                            </td>

                                            <!-- Last transaksi -->
                                            <td>
                                                <small>
                                                    @if(!empty($item['last_pengambilan']))
                                                    {{ \App\Helpers\IndoDateFormat::formatIndo($item['last_pengambilan']) }}
                                                    @else
                                                    <span class="text-muted fst-italic">BLM PERNAH NGAMBIL</span>
                                                    @endif
                                                </small>
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if($item['hari_tidak_ambil'] > 90)
                                                <span class="badge bg-danger">
                                                    {{ $item['hari_tidak_ambil'] }} hari
                                                </span>
                                                @elseif($item['hari_tidak_ambil'] > 30)
                                                <span class="badge bg-warning text-dark">
                                                    {{ $item['hari_tidak_ambil'] }} hari
                                                </span>
                                                @else
                                                <span class="badge bg-secondary">
                                                    {{ $item['hari_tidak_ambil'] }} hari
                                                </span>
                                                @endif
                                            </td>

                                            <td>
                                                <small class="text-muted">
                                                    <a target="_blank" href="{{ route('appSupplierVisitLogsPage', ['supplierId' => $item['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a>
                                                </small>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- EMPTY STATE -->
                            @if(empty($inactivePengrajin['data']))
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-check-circle fs-4"></i>
                                <p class="mb-0">Semua pengrajin aktif</p>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>