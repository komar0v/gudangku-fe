<div>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>

    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Input Barang Keluar/Masuk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item active">In Out Item</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @if($successMessage)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ $successMessage }}
                <button type="button" class="btn-close" wire:click="clearAlert" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errorMessage)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ $errorMessage }}
                <button type="button" class="btn-close" wire:click="clearAlert" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{route('appInventoryIndexPage')}}" class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col-6">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Data Barang Masuk/Keluar</h5>
                            <form class="row g-3" wire:submit.prevent="save">
                                <div class="profile-card d-flex flex-column align-items-center">
                                    <div class="col-12">
                                        <label for="type" class="form-label">Jenis</label>
                                        <select wire:model="type" id="type" class="form-control form-control-lg">
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="in">Barang Masuk</option>
                                            <option value="out">Barang Keluar</option>
                                        </select>
                                        @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-12 pt-2" wire:ignore>
                                        <label class="form-label">Barang</label>
                                        <select wire:change="cekStok($event.target.value)" wire:model="item_id" style="width: 100%;" id="selectItem">
                                            <option value="" disabled selected>-Pilih Barang-</option>
                                            @foreach ($listItems as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['nama_kategori'] }} | {{ $item['nama_barang'] }}</option>
                                            @endforeach
                                        </select>
                                        <script>
                                            new SlimSelect({
                                                select: '#selectItem'
                                            })
                                        </script>
                                    </div>
                                    @error('item_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="col-12 pt-2">
                                        <label class="form-label">Quantity</label>
                                        <input type="text" class="form-control" placeholder="Quantity" wire:model="quantity">
                                        @error('quantity')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 pt-2">
                                        <label class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" placeholder="Keterangan opsional" wire:model="keterangan">
                                        @error('keterangan')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center pt-2">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stok ketersediaan</h5>

                            <div id="loading" wire:loading wire:target="cekStok" style="text-align: center;">
                                <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                <p>loading...</p>
                            </div>

                            <div wire:loading.remove wire:target="cekStok">
                                @if(!empty($stokData))
                                <p><strong>Nama Barang :</strong> {{ $stokData['nama_barang']??'0' }}</p>
                                <p><strong>Kategori :</strong> {{ $stokData['nama_kategori']??'0' }}</p>
                                <p><strong>Stok :</strong> {{ $stokData['quantity']??'0' }} {{ $stokData['kode_satuan']??'' }}</p>
                                @else
                                <p>Silakan pilih barang untuk melihat stok.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>



        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />
</div>