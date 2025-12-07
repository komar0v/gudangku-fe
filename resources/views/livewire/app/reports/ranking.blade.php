<div>
    <style>
        .rank-gold {
            background: linear-gradient(to right, #FFD700, #FFC400);
            font-weight: bold;
            color: #5a4300 !important;
        }

        .rank-silver {
            background: linear-gradient(to right, #C0C0C0, #D3D3D3);
            font-weight: bold;
            color: #4a4a4a !important;
        }

        .rank-bronze {
            background: linear-gradient(to right, #CD7F32, #C8752E);
            font-weight: bold;
            color: #4a2e00 !important;
        }
    </style>

    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Ranking Pengrajin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Report</li>
                    <li class="breadcrumb-item active">Ranks</li>
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
                <div class="col-lg-12">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Ranking Pengrajin</h5>
                            <p>Ranking pengrajin berdasarkan transaksi terbanyak dan pengembalian terbanyak</p>
                            <form>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <p>Tanggal Awal</p>
                                        @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-6 text-center">
                                        <p>Tanggal Akhir</p>
                                        @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="input-group">
                                            <input wire:model="startDate" type="date" class="form-control" placeholder="Tanggal Awal">
                                            <span class="input-group-text">s/d</span>
                                            <input wire:model="endDate" type="date" class="form-control" placeholder="Tanggal Akhir">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col text-end">
                                        <button wire:click.prevent="showData" class="btn btn-primary">Tampilkan Data</button>
                                        <button wire:click.prevent="showGraph" class="btn btn-primary">Tampilkan Grafik</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                @if($isData && !empty($rankData))
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">RANK#</th>
                                        <th scope="col">Pengrajin</th>
                                        <th scope="col">Total Transaksi</th>
                                        <th scope="col">Total Berat Kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankData['ranking'] as $data)
                                    <tr>
                                        <th scope="row">
                                            {{$data['ranking']}}
                                            @if($data['ranking'] == 1) 🏆
                                            @elseif($data['ranking'] == 2) 🥈
                                            @elseif($data['ranking'] == 3) 🥉
                                            @endif
                                        </th>
                                        <td>{{$data['pengrajin']}}</td>
                                        <td>{{$data['total_selesai']}}</td>
                                        <td>{{$data['total_berat_kembali']}} Kg</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                @endif

                @if($isGraph && !empty($rankData))
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="barChart" wire:ignore></div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

        </section>


    </main><!-- End #main -->

    <script>
        (function() {

            let chart = null;

            function initApexGraph(payload) {

                // Cek elemen dulu
                const el = document.querySelector("#barChart");
                if (!el) {
                    console.warn("loading chart...");
                    return setTimeout(() => initApexGraph(payload), 150);
                }

                const ranking = payload?.detail?.ranking ?? [];
                const categories = ranking.map(item => item.pengrajin);
                const values = ranking.map(item => item.total_selesai);

                if (chart) chart.destroy();

                let dynamicHeight = ranking.length * 40;
                if (dynamicHeight < 400) dynamicHeight = 400;

                chart = new ApexCharts(el, {
                    series: [{
                        name: "Total Transaksi Selesai",
                        data: values
                    }],
                    chart: {
                        type: 'bar',
                        height: dynamicHeight
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 5,
                            horizontal: true,
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    xaxis: {
                        categories: categories,
                    }
                });

                chart.render();
            }

            // listener Livewire
            window.addEventListener('init-apex-graph', initApexGraph);

        })();
    </script>


    <livewire:PartialView.App.Footer />
</div>