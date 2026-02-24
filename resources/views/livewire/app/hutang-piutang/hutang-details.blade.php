<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Hutang</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Hutang Piutang</li>
                    <li class="breadcrumb-item active">Detail</li>
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

            <div class="row">
                <div class="col">
                    <div class="card shadow-sm border-0 pt-2">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-receipt me-2"></i>
                                    Detail Hutang
                                </h5>

                                @if($detailHutang['status'] === 'active')
                                <span class="badge bg-danger px-3 py-2">
                                    Masih Aktif
                                </span>
                                @else
                                <span class="badge bg-success px-3 py-2">
                                    Lunas
                                </span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <strong>Pengrajin:</strong>
                                {{ $detailHutang['pengrajin']['nama_pengrajin'] }}
                            </div>

                            <div class="row text-center mb-4">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light">
                                        <small>Total Hutang</small>
                                        <h5 class="fw-bold text-dark">
                                            Rp {{ number_format($detailHutang['total_hutang'], 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light">
                                        <small>Sisa Hutang</small>
                                        <h5 class="fw-bold text-danger">
                                            Rp {{ number_format($detailHutang['sisa_hutang'], 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light">
                                        <small>Sudah Dibayar</small>
                                        <h5 class="fw-bold text-success">
                                            Rp {{ number_format($detailHutang['total_hutang'] - $detailHutang['sisa_hutang'], 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Progress Pembayaran</label>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: {{ $persen }}%">
                                        {{ number_format($persen, 0) }}%
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-clock-history me-2"></i>
                                Riwayat Cicilan
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jumlah Bayar</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($detailHutang['cicilan'] as $cicilan)
                                        <tr>
                                            <td>
                                                {{ \App\Helpers\IndoDateFormat::formatIndo($cicilan['created_at']) }}
                                            </td>
                                            <td class="text-success fw-semibold">
                                                Rp {{ number_format($cicilan['jumlah_bayar'], 0, ',', '.') }}
                                            </td>
                                            <td>
                                                {{ $cicilan['keterangan'] ?? '-' }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                Belum ada pembayaran
                                            </td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>

                                @if($detailHutang['status'] === 'active')
                                <div class="text-center">

                                    <button type="button"
                                        class="btn btn-primary px-4"
                                        data-bs-toggle="modal"
                                        data-bs-target="#mdlPayDebt">
                                        <i class="bi bi-cash-coin me-1"></i>
                                        Bayar Hutang
                                    </button>

                                    <div wire:ignore.self class="modal fade" id="mdlPayDebt" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow border-0">

                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">
                                                        <i class="bi bi-wallet2 me-2"></i>
                                                        Pembayaran Hutang
                                                    </h5>
                                                    <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal">
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    {{-- Jumlah Bayar --}}
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Jumlah Bayar
                                                        </label>

                                                        <input type="number"
                                                            wire:model.defer="jumlah_bayar"
                                                            class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                                            placeholder="Masukkan nominal pembayaran">

                                                        @error('jumlah_bayar')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Keterangan
                                                        </label>

                                                        <textarea wire:model.defer="keterangan"
                                                            class="form-control @error('keterangan') is-invalid @enderror"
                                                            rows="3"
                                                            placeholder="Opsional..."></textarea>

                                                        @error('keterangan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Batal
                                                    </button>

                                                    <button type="button"
                                                        wire:click="payDebt"
                                                        wire:loading.attr="disabled"
                                                        class="btn btn-primary">

                                                        <span wire:loading.remove wire:target="payDebt">
                                                            <i class="bi bi-check-circle me-1"></i>
                                                            Bayar
                                                        </span>

                                                        <span wire:loading wire:target="payDebt">
                                                            <span class="spinner-border spinner-border-sm"></span>
                                                            Memproses...
                                                        </span>

                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </section>

    </main><!-- End #main -->
    <script>
        window.addEventListener('close-modal', () => {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('mdlPayDebt')
            );
            modal.hide();
        });
    </script>

    <livewire:PartialView.App.Footer />
</div>