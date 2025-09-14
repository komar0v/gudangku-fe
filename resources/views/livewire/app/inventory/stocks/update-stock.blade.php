<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Stok Barang</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Inventory Master</li>
                    <li class="breadcrumb-item">All Stocks</li>
                    <li class="breadcrumb-item active">Detail Stock</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @if($successMessage)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ $successMessage }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{route('appAllStocksPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Stok Barang</h5>
                            <form wire:submit.prevent="updateStock">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Quantity</label>
                                    <div class="col-sm-10">
                                        <div class="input-group mb-3">
                                            <input wire:model="stock_quantity" type="number" step="any" min="0" class="form-control" placeholder="misal: 10.0">
                                            <span class="input-group-text">{{$itemData['satuan']['kode_satuan']}}</span>
                                        </div>
                                        @error('stock_quantity')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">

                                    <p class="text-muted">Update stok akan langsung mengubah jumlah stok menjadi sesuai kondisi nyata. Gunakan hanya jika ingin menyamakan data dengan stok sebenarnya.</p>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 contact">
                    <div class="info-box card">
                        <div class="row" wire:poll="fetchStock">
                            <div class="col">
                                <i class="bi bi-box-seam"></i>
                                <h3>Stok Saat Ini</h3>
                                <h5><b>{{$stockData['quantity']}}</b> {{$itemData['satuan']['nama_satuan']}} ({{$itemData['satuan']['kode_satuan']}})</h5>
                            </div>
                            <div class="col">
                                <h6>Kategori : {{$itemData['kategori']['nama_kategori']}}</h6>
                                <h6>Nama Barang : {{$itemData['nama_barang']}}</h6>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            @if(!empty($stockLogsData))
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pergerakan Stok Barang ini pada bulan {{$bulanIni}}</h5>

                            
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">TIPE</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Stok Sebelum</th>
                                        <th scope="col">Stok Setelah</th>
                                        <th scope="col">Transaksi</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockLogsData as $stockLog)
                                    <tr>
                                        <th scope="row">{{$stockLog['type']}}</th>
                                        <td>{{$stockLog['quantity']}}</td>
                                        <td>{{$stockLog['stock_before']}}</td>
                                        <td>{{$stockLog['stock_after']}}</td>
                                        <td>@if(!empty($stockLog['transaction_id']))
                                            <a target="_blank" href="{{ route('appTransactionDetails', ['transactionId' => $stockLog['transaction_id']]) }}">
                                                Lihat Transaksi
                                            </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>{{$stockLog['keterangan']}}</td>
                                        <td>{{$stockLog['created_at']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>


    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>