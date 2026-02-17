<div>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    <livewire:PartialView.App.Header />
    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Hutang Pengrajin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Hutang Piutang</li>
                    <li class="breadcrumb-item active">Filter</li>
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
                <div class="col-lg-12">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Lihat Hutang Pengrajin</h5>
                            <p>Filter data hutang berdasarkan pengrajin</p>
                            <form>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Pengrajin</label>
                                    <div class="col-sm-10" wire:ignore>
                                        <select wire:model="pengrajinId" style="width: 100%;" id="selectPengrajin" wire:key="selectPengrajin-{{ count($pengrajinLists) }}">>
                                            <option value="" disabled selected>-Pilih Pengrajin-</option>
                                            @foreach ($pengrajinLists as $pengrajin)
                                            <option value="{{ $pengrajin['id'] }}">{{ $pengrajin['nama_pengrajin'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center">
                                        <button wire:click.prevent="showData" class="btn btn-primary"><i class="bi bi-eye me-1"></i>Lihat</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                @if(!empty($hutangDatas))
                <div class="col-12">
                    <div class="card shadow-sm border-0 pt-4">
                        <div class="card-body">

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
                                            {{ $hutangDatas['total_hutang_active'] }} Transaksi
                                        </h5>
                                    </div>
                                </div>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">

                                    <thead class="table-light">
                                        <tr>
                                            <th>ID Transaksi</th>
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
                                            <td class="fw-semibold">
                                                {{ explode('-', $hutang['transaction_id'])[1] ?? '-' }}
                                            </td>

                                            <td>
                                                Rp {{ number_format($hutang['total_hutang'], 0, ',', '.') }}
                                            </td>

                                            <td class="text-danger fw-semibold">
                                                Rp {{ number_format($hutang['sisa_hutang'], 0, ',', '.') }}
                                            </td>

                                            <td>
                                                @if($hutang['status'] == 'active')
                                                <span class="badge bg-danger">Active</span>
                                                @else
                                                <span class="badge bg-success">Lunas</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($hutang['created_at'])->format('d M Y') }}
                                            </td>

                                            <td>
                                                <a target="_blank" href="{{ route('appHutangDetails', ['transactionId' => $hutang['transaction_id']]) }}" class="btn btn-sm btn-outline-primary w-100">Detail Hutang</a>
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
                @endif

            </div>

        </section>


    </main><!-- End #main -->
    <script>
        (function() {
            let ss2 = null;

            function initSlim2() {
                const el = document.getElementById('selectPengrajin');
                if (!el) return;

                if (ss2 && typeof ss.destroy === 'function') {
                    ss2.destroy();
                    ss2 = null;
                }
                ss2 = new SlimSelect({
                    select: el
                });
            }

            document.addEventListener('DOMContentLoaded', initSlim2);

            window.addEventListener('init-slim-select2', () => {
                requestAnimationFrame(initSlim2);
            });
        })();
    </script>
    <livewire:PartialView.App.Footer />
</div>