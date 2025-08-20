<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
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

            @if(session('auth_data.accountdata.role_code')=='RL_SA')
            <div class="row">

                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-4">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Pengembalian <span>| Hari ini</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ri ri-arrow-right-down-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$ambilKembaliToday['kembali']??'X'}}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-4">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Pengambilan <span>| Hari ini</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ri ri-arrow-left-up-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$ambilKembaliToday['ambil']??'X'}}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-4">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Total Pengrajin</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$countSupplier}}</h6>
                                        <span class="text-muted small pt-2 ps-1">Pengrajin</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                </div>
                <div class="row">

                    <div class="col-2">
                        <div class="card info-card customers-card">
                            <a href="{{route('appSupplierSearchByBarcodePage')}}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Cari Pengrajin</h5>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bx bx-barcode-reader"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>Scan</h6>
                                            <span class="text-muted pt-2">Barcode</span>

                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-4">

                        <div class="card info-card sales-card">
                            <a href="{{route('appItemInPage')}}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Input Pengembalian</h5>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri ri-arrow-right-down-fill"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-4">

                        <div class="card info-card revenue-card">
                            <a href="{{route('appItemOutPage')}}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Input Pengambilan</h5>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri ri-arrow-left-up-fill"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="card info-card">
                            <a href="{{route('appPantauStokPage')}}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Lihat Statistik</h5>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="bg-info card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-earmark-bar-graph"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>Statistik</h6>
                                            <span class="text-muted pt-2">Ambil/Kembali</span>

                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <!-- Reports -->
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Laporan<span> | 7 hari terakhir</span><br><span>{{$reportRange}}</span>
                            </h5>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const categories = {!! $chart_cat !!};

                                    const kembali = {!! $chart_k !!};
                                    const ambil = {!! $chart_a !!};

                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                                name: 'Pengembalian',
                                                data: kembali
                                            },
                                            {
                                                name: 'Pengambilan',
                                                data: ambil
                                            },
                                        ],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            },
                                            zoom: {
                                                enabled: false
                                            },
                                            panning: {
                                                enabled: false
                                            }
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154F1', '#2ECA6A'],
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 100]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 2
                                        },
                                        xaxis: {
                                            type: 'datetime',
                                            categories: categories
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'dd/MM/yy'
                                            }
                                        },
                                    }).render();
                                });
                            </script>
                            <!-- End Line Chart -->

                        </div>

                    </div>
                </div><!-- End Reports -->
            </div>
            @else
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Coming soon</h5>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>