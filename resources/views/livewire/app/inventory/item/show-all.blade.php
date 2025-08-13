<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Semua Item/Barang Inventory</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Inventory Master</li>
                    <li class="breadcrumb-item active">All Items</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

        </section>

        <section class="section">
            <a href="{{route('appInventoryIndexPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pt-2">
                                <div class="col">
                                    <h5 class="card-title">Semua Item/barang</h5>
                                    <p>Menampilkan semua item/barang yang ada dalam sistem.</p>
                                </div>
                                <div class="col pt-4">
                                    <div class="text-end">
                                        <a href="{{route('appAddItemPage')}}" wire:navigate class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Barang</a>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($itemList as $item)
                                    <tr>
                                        <td>{{$item['nama_barang']}}</td>
                                        <td>{{$item['kategori']['nama_kategori']}}</td>
                                        <td><a wire:navigate href="{{ route('appItemDetailsPage', ['itemId' => $item['id']]) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Detail</a></td>
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