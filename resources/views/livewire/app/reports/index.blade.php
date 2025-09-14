<div>
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

                                <a wire:click="showInvGraphMonthly" class="btn btn-info"><i class="bi bi-arrow-up-right me-1"></i>Tampilkan Grafik</a>
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
                                <a wire:click="showInvGraphDaily" class="btn btn-info"><i class="bi bi-arrow-up-right me-1"></i>Tampilkan Grafik</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>