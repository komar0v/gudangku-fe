<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Semua Stok Barang</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Inventory Master</li>
                    <li class="breadcrumb-item active">All Stocks</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <a href="{{route('appInventoryIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Semua Stok Barang</h5>
                            <p>Menampilkan daftar stok barang secara lengkap beserta jumlah persediaannya.</p>
                            <hr>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($stokBarangList as $item)
                                    <tr>
                                        <td>{{$item['nama_barang']}}</td>
                                        <td>{{$item['nama_kategori']}}</td>
                                        <td class="{{ (isset($item['quantity']) && $item['quantity'] < $batasTresholdStok) ? 'text-danger' : '' }}">
                                            {{ (!isset($item['quantity']) || $item['quantity'] == 0) ? 'Kosong' : $item['quantity'] }}
                                        </td>

                                        <td>
                                            {{ $item['satuan']['kode_satuan'] }}
                                        </td>
                                        <td>
                                            <a href="{{route('appUpdateStocksPage',['itemId'=>$item['item_id']])}}" class="btn btn-success btn-sm">Detail Stok</a>
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