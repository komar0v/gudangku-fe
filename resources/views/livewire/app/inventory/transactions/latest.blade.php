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
            <h1>Transaksi Terbaru</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Transaction</li>
                    <li class="breadcrumb-item active">Latest</li>
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

            <div class="row" wire:poll="fetchData">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <p class="muted">Transaksi terbaru dalam 10 jam terakhir</p>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">TRX ID</th>
                                        <th scope="col">Pengrajin</th>
                                        <th scope="col">Tanggal Pengambilan</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestTransactions as $data)
                                    <tr>
                                        <th scope="row">{{ explode('-', $data['id'])[1] }}</th>
                                        <td>{{ $data['nama_pengrajin'] ?? '-' }}</td>
                                        <td>{{$data['timestamp_pengambilan']}}</td>
                                        <td><a target="_blank" href="{{ route('appTransactionDetails', ['transactionId' => $data['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a></td>
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