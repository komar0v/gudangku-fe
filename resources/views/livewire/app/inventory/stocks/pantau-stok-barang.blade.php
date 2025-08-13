<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Pantau Stok Barang <span wire:ignore class="text-muted" id="timestamp">| </span></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Stocks</li>
                    <li class="breadcrumb-item active">Observer</li>
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

        </section>

        <section class="section dashboard">
            <div>
                <div class="row" wire:poll.7s="fetchStatistics">
                    <div class="col-lg-12">

                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Ringkasan</h5>

                                <div class="row">

                                    <div class="col-4">

                                        <div class="card-body">
                                            <h5 class="card-title">Barang Masuk</h5>

                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="ri ri-arrow-right-down-fill"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{$barangKeluarMasukToday['barang_masuk']}}</h6>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-4">

                                        <div class="card-body">
                                            <h5 class="card-title">Barang Keluar</h5>

                                            <div class="d-flex align-items-center revenue-card">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="ri ri-arrow-left-up-fill"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{$barangKeluarMasukToday['barang_keluar']}}</h6>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-4">

                                        <div class="card-body">
                                            <h5 class="card-title">Barang Hampir Habis</h5>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
                                                            <i class="bx bx-error"></i>
                                                        </div>
                                                        <div class="ps-3">
                                                            <h6>{{$lowStokItemCount}}</h6>
                                                            <span class="text-muted small pt-2 ps-1">Item</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="d-flex align-items-center">

                                                        <a wire:navigate href="{{route('appLowStokPage')}}" class="btn btn-warning"><i class="bi bi-border-bottom me-1"></i>Cek Stok</a>
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
                                <h5 class="card-title">Grafik Keluar Masuk</h5>
                                <div id="pieChart"></div>

                                
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {

                                        const barangMasuk = {!! $barangKeluarMasukToday['barang_masuk'] !!};
                                        const barangKeluar = {!! $barangKeluarMasukToday['barang_keluar'] !!};

                                        new ApexCharts(document.querySelector("#pieChart"), {
                                            series: [barangMasuk, barangKeluar],
                                            chart: {
                                                height: 350,
                                                type: 'pie',
                                                toolbar: {
                                                    show: true
                                                }
                                            },
                                            labels: ['Masuk', 'Keluar'],
                                            colors: ['#0d6efd', '#2ECA6A', '#dc3545']
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Statistik Supplier</h5>
                                <div id="columnChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#columnChart"), {
                                            series: [{
                                                name: 'Barang Masuk',
                                                data: {!! $barangMasuk !!}
                                            }, ],
                                            chart: {
                                                type: 'bar',
                                                height: 350
                                            },
                                            colors: ['#0d6efd'],
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
                                                categories: {!! $namaSupplier !!}
                                            },
                                            yaxis: {
                                                title: {
                                                    text: 'Barang'
                                                }
                                            },
                                            fill: {
                                                opacity: 1
                                            },
                                            tooltip: {
                                                y: {
                                                    formatter: function(val) {
                                                        return val + " barang"
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

            <div class="row" wire:ignore>
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Lihat Semua Stok Barang</h5>
                            <p>Menampilkan daftar stok barang secara lengkap beserta jumlah persediaannya.</p>
                            <a wire:navigate href="{{route('appAllStokPage')}}" class="btn btn-primary"><i class="bi bi-card-list me-2"></i>Lihat Semua Stok</a>
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