<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Kunjungan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Pengrajin Master</li>
                    <li class="breadcrumb-item">Detail</li>
                    <li class="breadcrumb-item active">Visit Log</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <a href="{{route('appSupplierDetailPage', ['supplierId'=> $suppId])}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">TRX ID</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Waktu Pengambilan</th>
                                        <th scope="col">Waktu Pengembalian</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($visitLogs as $log)
                                    <tr>
                                        <td>{{ explode('-', $log['id'])[1] }}</td>
                                        <td>{{$log['item']['nama_barang']}}</td>
                                        <td>{{$log['timestamp_pengambilan']}}</td>
                                        <td>@if ($log['timestamp_pengembalian'])
                                            {{ $log['timestamp_pengembalian'] }}
                                            @else
                                            <span class="text-danger">BELUM ADA</span>
                                            @endif
                                        </td>
                                        <td><a wire:navigate href="{{ route('appTransactionDetails', ['transactionId' => $log['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a></td>
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