<div>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Buat Laporan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Report</li>
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

            <div class="row">
                <div class="col-lg-6">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Laporan Inventory Bulanan</h5>
                            <p>Laporan inventory barang keluar masuk berdasarkan bulan yang dipilih</p>
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-2 col-form-label">Bulan</label>
                                <div class="col-sm-10">
                                    <input wire:model="dateBulanan" type="month" class="form-control">
                                    @error('dateBulanan')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">

                                <a wire:click="cetakLaporanInvBulanan" class="btn btn-info"><i class="bi bi-download me-1"></i>Download PDF</a>

                                <div wire:loading wire:target="cetakLaporanInvBulanan">
                                    <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Laporan Inventory Harian</h5>
                            <p>Laporan inventory barang keluar masuk berdasarkan tanggal yang dipilih</p>
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-10">
                                    <input wire:model="dateHarian" type="date" class="form-control">
                                </div>
                                @error('dateHarian')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <a wire:click="cetakLaporanInvHarian" class="btn btn-info"><i class="bi bi-download me-1"></i>Download PDF</a>
                                <div wire:loading wire:target="cetakLaporanInvHarian">
                                    <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Laporan Transaksi Pengrajin</h5>
                            <p>Laporan inventory barang keluar masuk berdasarkan pengrajin dan tanggal yang dipilih</p>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-10">
                                    <input wire:model="startDatePeng" type="date" class="form-control">
                                </div>
                                @error('startDatePeng')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal Akhir</label>
                                <div class="col-sm-10">
                                    <input wire:model="endDatePeng" type="date" class="form-control">
                                </div>
                                @error('endDatePeng')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

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
                            @error('pengrajinId')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <a wire:click="cetakLaporanInvPengrajin" class="btn btn-info"><i class="bi bi-download me-1"></i>Download PDF</a>
                            <div wire:loading wire:target="cetakLaporanInvPengrajin">
                                <img width="60" height="60" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Laporan Keuangan/Cashflow</h5>
                            <p>Lihat laporan keuangan secara lengkap</p>

                            <div class="text-center">
                                <a wire:navigate href="{{route('appHistoryCashflowPage')}}" class="btn btn-info"><i class="bi bi-card-list me-1"></i>Lihat Laporan</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
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