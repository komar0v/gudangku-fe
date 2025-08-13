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
                            <h5 class="card-title">Tampilkan Laporan Inventory</h5>
                            <p>Laporan inventory berdasarkan periode waktu yang dipilih</p>
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-10">
                                    <input wire:model="date" type="month" class="form-control">
                                    @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <a wire:click="cetakLaporan" class="btn btn-info me-1"><i class="bi bi-download"></i>Download PDF</a>

                                <a wire:click="showGraph" class="btn btn-info"><i class="bi bi-arrow-up-right me-1"></i>Tampilkan Grafik</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>