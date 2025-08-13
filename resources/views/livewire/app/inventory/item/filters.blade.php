<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Filter Item/Barang Inventory</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Inventory Master</li>
                    <li class="breadcrumb-item active">Filter Items</li>
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
                            <h5 class="card-title">Filter Item/barang</h5>
                            <p>Tampilkan semua item/barang berdasarkan kategori.</p>
                            <form wire:submit.prevent="doFilter">
                                <div class="form-floating mb-3">
                                    <select wire:model="filterbykategori" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                        <option selected value="">Pilih Kategori</option>
                                        @foreach($categoryList as $kategori)
                                        <option value="{{$kategori['id']}}">{{$kategori['nama_kategori']}}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Kategori</label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-filter-alt me-2"></i>Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($filterbykategori))
            <div class="row pt-2">
                <div class="col">
                    <div class="card">
                        <div class="card-body pt-3">

                            <table class="table table-hover">
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
            @endif

        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>