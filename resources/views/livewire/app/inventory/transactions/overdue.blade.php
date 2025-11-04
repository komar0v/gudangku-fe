<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Transaksi Barang Belum Kembali</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Belum Kembali</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Transaksi barang yang belum kembali selama 10 hari atau lebih dari tanggal ambil</h5>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Trx ID</th>
                                        <th scope="col">Pengrajin</th>
                                        <th scope="col">Tanggal Ambil</th>
                                        <th scope="col">Hari Terlewati</th>
                                        <th scope="col">Detail</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($transactionOverdueList as $transData)
                                    <tr>
                                        <td>{{ explode('-', $transData['id'])[1] }}</td>
                                        <td>{{$transData['pengrajin']}}</td>
                                        <td>{{$transData['tanggal_pengambilan']}}</td>
                                        <td>{{$transData['hari_terlewati']}}</td>
                                        <td><a target="_blank" href="{{ route('appTransactionDetails', ['transactionId' => $transData['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a></td>
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