<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Keuangan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Cashflow</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section" wire:poll="fetchData">

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
                <div class="col-6 dashboard">
                    <div class="card info-card sales-card">
                        <a href="{{route('appCreateCashflowPage')}}">
                            <div class="card-body">
                                <h5 class="card-title text-center">Catat Data Pengeluaran/Pemasukan Baru</h5>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="d-flex align-items-center text-center revenue-card">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box-arrow-in-up"></i>
                                        </div>
                                    </div>
                                    <p style="font-size: 40px;">/</p>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box-arrow-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6 contact">
                    <div class="card">
                        <h5 class="card-title text-center">Ringkasan 7 Hari Terakhir</h5>
                        <div class="card-body info-box">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <i style="color: #2ECA6A;" class="bi bi-box-arrow-in-up"></i>
                                        <div class="ps-3">
                                            <h5>Rp. {{ number_format($cashflowSummary['total_out'], 0, ',', '.') }}</h5>
                                            <span class="text-muted pt-2 ps-1">Pengeluaran</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">

                                    <div class="d-flex align-items-center">
                                        <i style="color: #4154F1;" class="bi bi-box-arrow-down"></i>
                                        <div class="ps-3">
                                            <h5>Rp. {{ number_format($cashflowSummary['total_in'], 0, ',', '.') }}</h5>
                                            <span class="text-muted pt-2 ps-1">Pemasukan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title text-center">{{$periodeFormatted}}</h5>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Kategori Cashflow</h5>
                                    <p>Kelola kategori cashflow untuk mengatur jenis pemasukan atau pengeluaran.</p>
                                    <a wire:navigate href="{{route('appManageCashflowCategoryPage')}}" class="btn btn-primary"><i class="bi bi-view-stacked me-2"></i>Kelola Kategori</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Lihat Cashflow</h5>
                                    <p>Tampilkan daftar transaksi pemasukan dan pengeluaran secara lengkap</p>
                                    <a wire:navigate href="{{route('appHistoryCashflowPage')}}" class="btn btn-primary"><i class="bi bi-card-list me-2"></i>Lihat Cashflow</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cashflow Terbaru</h5>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentCashflow as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $data['category']['name'] }}</td>
                                        <td><span class="text-truncate">{{ $data['description'] }}</span></td>
                                        <td>
                                            @if($data['type'] === 'in')
                                            <span class="badge" style="background-color:#4154F1;">Masuk</span>
                                            @else
                                            <span class="badge" style="background-color:#2ECA6A;">Keluar</span>
                                            @endif
                                        </td>
                                        <td>Rp. {{ number_format($data['amount'], 0, ',', '.') }}</td>
                                        <td>
                                            <a wire:navigate href="{{route('appDetailCashflowPage', ['cashflowId' => $data['id']])}}" type="button" class="btn btn-success btn-sm">
                                                <i class="bi bi-eye-fill me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>