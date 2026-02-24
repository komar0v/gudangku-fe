<div>
    <livewire:PartialView.App.Header />
    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Peminjaman Baru</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Hutang Piutang</li>
                    <li class="breadcrumb-item active">Peminjaman Baru</li>
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
            <a href="{{route('appHutangStatisticsPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 pt-4">
                        <div class="card-body">

                            <div class="row">

                                {{-- ================= DETAIL PEMINJAM ================= --}}
                                <div class="col-md-5 border-end">

                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-person-circle fs-4 me-2 text-primary"></i>
                                        Detail Peminjam
                                    </h6>

                                    <div class="mb-3">
                                        <small class="text-muted d-block">Nama</small>
                                        <div class="fw-semibold">
                                            {{ $pengrajinDatas['nama_pengrajin'] ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted d-block">Alamat</small>
                                        <div class="fw-semibold">
                                            {{ $pengrajinDatas['alamat'] ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted d-block">Nomor HP</small>
                                        <div class="fw-semibold">
                                            +62{{ $pengrajinDatas['nomer_wa'] ?? '-' }}
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-7">

                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-cash-coin fs-4 me-2 text-success"></i>
                                        Form Pinjam Uang
                                    </h6>

                                    <div class="mb-3">
                                        <small class="text-muted d-block mb-2">
                                            Pilih Nominal
                                        </small>

                                        <div class="d-flex flex-wrap gap-2">

                                            <button type="button"
                                                wire:click="setNominal(50000)"
                                                class="btn btn-outline-primary btn-sm">
                                                50K
                                            </button>

                                            <button type="button"
                                                wire:click="setNominal(100000)"
                                                class="btn btn-outline-primary btn-sm">
                                                100K
                                            </button>

                                            <button type="button"
                                                wire:click="setNominal(200000)"
                                                class="btn btn-outline-primary btn-sm">
                                                200K
                                            </button>

                                            <button type="button"
                                                wire:click="setNominal(500000)"
                                                class="btn btn-outline-primary btn-sm">
                                                500K
                                            </button>

                                            <button type="button"
                                                wire:click="setNominal(1000000)"
                                                class="btn btn-outline-primary btn-sm">
                                                1JT
                                            </button>

                                        </div>
                                    </div>

                                    <form wire:submit.prevent="pinjamUang">
                                        <div class="mb-3">
                                            <label class="form-label small text-muted">
                                                Nominal Custom
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    wire:model.lazy="nominal"
                                                    wire:input="formatNominal"
                                                    placeholder="Masukkan nominal pinjaman">
                                            </div>
                                            @error('nominal')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label small text-muted">
                                                Keterangan
                                            </label>
                                            <textarea wire:model="keterangan" class="form-control"
                                                rows="2"
                                                placeholder="Tambahkan catatan (opsional)"></textarea>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Pinjam Uang
                                            </button>
                                        </div>
                                    </form>

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