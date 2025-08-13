<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Stok Barang Hampir Habis</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Stocks</li>
                    <li class="breadcrumb-item active">Low Stocks</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <a href="{{route('appPantauStokPage')}}" class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stok Barang Hampir Habis</h5>
                            <p>Menampilkan daftar stok barang yang jumlah persediaannya dibawah 10</p>
                            <hr>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Berat Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($stokBarangList as $item)
                                    <tr>
                                        <td>{{$item['nama_barang']}}</td>
                                        <td>{{$item['kategori']['nama_kategori']}}</td>
                                        <td class="{{ $item['stok']['jumlah'] ?? null ? '' : 'text-danger' }}">
                                            {{ $item['stok']['jumlah'] ?? 'Kosong' }}
                                        </td>
                                        <td class="{{ $item['stok']['berat_total'] ?? null ? '' : 'text-danger' }}">
                                            {{ $item['stok']['berat_total'] ?? 'Kosong' }}
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