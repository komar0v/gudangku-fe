<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Statistik Inventory <span class="text-muted">{{$period}}</span></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Report</li>
                    <li class="breadcrumb-item active">Graph</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            <div class="row">
                <div class="col-lg-4">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Grafik Keluar Masuk</h5>
                            <div id="pieChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const barangMasuk = {!!$graphKeluarMasuk['total_barang_masuk'] !!};
                                    const barangKeluar = {!!$graphKeluarMasuk['total_barang_keluar'] !!};

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
                            <h5 class="card-title">Statistik Supplier</h5>
                            <div id="columnChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {

                                    const barangMasuk = {!!$totalMasuk!!};
                                    const namaSupplier = {!!$namaSupplier!!};

                                    new ApexCharts(document.querySelector("#columnChart"), {
                                        series: [{
                                            name: 'Barang Masuk',
                                            data: barangMasuk
                                        }, ],
                                        chart: {
                                            type: 'bar',
                                            height: 350
                                        },
                                        colors: ['#0d6efd', ],
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
                                            categories: namaSupplier
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

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Kategori Barang Masuk</h5>

                            <div id="barChartBarangMasuk"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {

                                    const barangMasuk = {!! $jumMasuk !!};
                                    const namaKategoriMasuk = {!! $namKatMasuk !!};

                                    new ApexCharts(document.querySelector("#barChartBarangMasuk"), {
                                        series: [{
                                            name: 'Barang Masuk',
                                            data: barangMasuk
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 350
                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 4,
                                                horizontal: true,
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        xaxis: {
                                            categories: namaKategoriMasuk
                                        },
                                        colors: ['#0d6efd'],
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

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Kategori Barang Keluar</h5>

                            <div id="barChartBarangKeluar"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {

                                    const barangKeluar = {!! $jumKeluar !!};
                                    const namaKategoriKeluar = {!! $namKatKeluar !!};

                                    new ApexCharts(document.querySelector("#barChartBarangKeluar"), {
                                        series: [{
                                            name: 'Barang Keluar',
                                            data: barangKeluar
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 350
                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 4,
                                                horizontal: true,
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        xaxis: {
                                            categories: namaKategoriKeluar
                                        },
                                        colors: ['#2ECA6A'],
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

        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>