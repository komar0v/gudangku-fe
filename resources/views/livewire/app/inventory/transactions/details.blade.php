<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Transaksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Pengrajin Master</li>
                    <li class="breadcrumb-item">Detail</li>
                    <li class="breadcrumb-item">Visit Log</li>
                    <li class="breadcrumb-item active">Transaction Details</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <a href="{{route('appSupplierVisitLogsPage', ['supplierId'=> $pengrjnId])}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">Data Barang</h5>

                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label">Kategori Barang</label>
                                        <div class="col-sm-4 mt-2">
                                            <p>{{$kategoriData['nama_kategori']}}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label">Nama Barang</label>
                                        <div class="col-sm-4 mt-2">
                                            <p>{{$transactionData['item']['nama_barang']}}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label">Harga</label>
                                        <div class="col-sm-4 mt-2">
                                            <p>Rp. {{number_format($transactionData['item']['harga'], 0, ',', '.')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="card-title">Data Pengrajin</h5>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Nama Pengrajin</label>
                                            <p>{{$pengrajinData['nama_pengrajin']}}</p>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Nomer WhatsApp</label>
                                            <p>+62{{$pengrajinData['nomer_wa']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Pengambilan(Ambil)</h5>

                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Waktu Pengambilan</label>
                                <div class="col-sm-6">
                                    <p>{{$waktuPengambilan ?? '-'}}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Berat Pengambilan</label>
                                <div class="col-sm-6">
                                    <p>{{$transactionData['berat_pengambilan'] ?? '-'}} {{$satuanData['nama_satuan']}}</p>
                                </div>
                            </div>

                            @if(!empty($waktuPengembalian))
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Upah (Harga barang X berat ambil)</label>
                                <div class="col-sm-6">
                                    <b>Rp. {{number_format(($transactionData['berat_pengambilan']*$transactionData['item']['harga']), 0, ',', '.')}}</b>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Pengembalian(Kembali)</h5>

                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Waktu Pengembalian</label>
                                <div class="col-sm-6">
                                    <p>{{$waktuPengembalian ?? '-'}}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Berat Pengembalian</label>
                                <div class="col-sm-6">
                                    <p>{{$transactionData['berat_pengembalian'] ?? '-'}} {{$satuanData['nama_satuan']}}</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            @if(session('auth_data.accountdata.role_code')=='RL_SA')
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Update Data</h5>
                            <p>Update data transaksi jika terdapat kesalahan/koreksi.</p>
                            <a href="{{route('appTransactionEdit', ['transactionId'=>$transactionData['id']])}}" class="btn btn-warning"><i class="bi bi-pencil me-2"></i>Update Data</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif


        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>