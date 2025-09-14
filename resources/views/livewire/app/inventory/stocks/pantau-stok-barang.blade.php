<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Statistik <span wire:ignore class="text-muted" id="timestamp">| </span></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Statistics</li>
                    <li class="breadcrumb-item active">Observer</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            <button type="button" onclick="window.location.reload(true)" class="btn btn-primary btn-sm mb-2"><i class="bi bi-arrow-clockwise me-1"></i>Refresh</button>

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

        </section>

        <section class="section dashboard">
            <div>
                <div class="row" wire:poll.7s="fetchStatistics">
                    <div class="col-lg-12">

                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <div class="row pt-2">

                                    <div class="col-4">

                                        <div class="card-body">
                                            <h5 class="card-title">Pengembalian</h5>

                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="ri ri-arrow-right-down-fill"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{$ambilKembaliToday['kembali'] ?? 0}}</h6>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-4">

                                        <div class="card-body">
                                            <h5 class="card-title">Pengambilan</h5>

                                            <div class="d-flex align-items-center revenue-card">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="ri ri-arrow-left-up-fill"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{$ambilKembaliToday['ambil']?? 0}}</h6>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-4">

                                        <div class="card-body">
                                            <h5 class="card-title">Stok Hampir Habis</h5>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
                                                            <i class="bx bx-error"></i>
                                                        </div>
                                                        <div class="ps-3">
                                                            <h6>{{$stokTipisCount}}</h6>
                                                            <span class="text-muted small pt-2 ps-1">Item</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="d-flex align-items-center">

                                                        <a href="{{route('appAllStocksPage')}}" wire:navigate class="btn btn-info">
                                                            <i class="bi bi-box-seam me-2"></i>Stok Barang
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row" wire:ignore>
                    <div class="col-lg-4">

                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Grafik Ambil-Kembali</h5>
                                <div id="pieChart"></div>

                                <input id="kembali" type="hidden" value="{{$ambilKembaliToday['kembali']}}">
                                <input id="ambil" type="hidden" value="{{$ambilKembaliToday['ambil']}}">

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {

                                        const barangMasuk = parseInt(document.getElementById("kembali").value) || 0;
                                        const barangKeluar = parseInt(document.getElementById("ambil").value) || 0;

                                        new ApexCharts(document.querySelector("#pieChart"), {
                                            series: [barangMasuk, barangKeluar],
                                            chart: {
                                                height: 350,
                                                type: 'pie',
                                                toolbar: {
                                                    show: true
                                                }
                                            },
                                            labels: ['Pengembalian', 'Pengambilan'],
                                            colors: ['#0d6efd', '#2ECA6A']
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Statistik Top 10 Pengrajin Hari Ini</h5>
                                <div id="columnChart"></div>

                                <input id="pluckPengambilan" type="hidden" value="{{$pluckAmbil}}">
                                <input id="pluckPengembalian" type="hidden" value="{{$pluckKembali}}">

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {

                                        const ambil = {!!$pluckAmbil!!};
                                        const kembali = {!!$pluckKembali!!};
                                        const pengrajin = {!!$pluckPengrajin!!};

                                        new ApexCharts(document.querySelector("#columnChart"), {
                                            series: [{
                                                name: 'Ambil',
                                                data: ambil
                                            }, {
                                                name: 'Kembali',
                                                data: kembali
                                            }, ],
                                            chart: {
                                                type: 'bar',
                                                height: 350
                                            },
                                            plotOptions: {
                                                bar: {
                                                    horizontal: false,
                                                    columnWidth: '55%',
                                                    endingShape: 'rounded'
                                                },
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                show: true,
                                                width: 2,
                                                colors: ['transparent']
                                            },
                                            xaxis: {
                                                categories: pengrajin,
                                            },
                                            yaxis: {
                                                title: {
                                                    text: 'Quantity'
                                                }
                                            },
                                            fill: {
                                                opacity: 1
                                            },
                                            tooltip: {
                                                y: {
                                                    formatter: function(val) {
                                                        return val
                                                    }
                                                }
                                            }
                                        }).render();
                                    });
                                </script>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>


    </main><!-- End #main -->

    <script>
        function updateTime() {
            const formatted = new Date().toLocaleString('sv-SE', {
                timeZone: 'Asia/Jakarta'
            }).replace('T', ' ');
            document.getElementById("timestamp").innerText = `| ${formatted}`;
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>

    <livewire:PartialView.App.Footer />
</div>