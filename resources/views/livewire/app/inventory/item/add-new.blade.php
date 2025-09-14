<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Item/Barang</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Inventory Master</li>
                    <li class="breadcrumb-item active">Add Item</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <a href="{{route('appShowAllItemsPage')}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Barang</h5>

                            <form class="row g-3" wire:submit.prevent="saveNewItem">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" wire:model="nama_barang">
                                        <label for="floatingName">Nama Barang</label>
                                    </div>
                                    @error('nama_barang')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="basic-url" class="form-label">Harga Barang</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon3">Rp.</span>
                                        <input wire:model="harga" type="text" class="form-control-lg" id="harga-barang">
                                        @error('harga')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <select required class="form-select" id="floatingSelect" aria-label="State" wire:model="kategori_id">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($categoryList as $kategori)
                                            <option value="{{ $kategori['id'] }}">{{ $kategori['nama_kategori'] }}</option>
                                            @endforeach

                                        </select>
                                        <label for="floatingSelect">Kategori Barang</label>
                                        @error('kategori_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <select required class="form-select" id="floatingSelect" aria-label="State" wire:model="satuan_id">
                                            <option value="">Pilih Satuan</option>
                                            @foreach ($satuanList as $satuan)
                                            <option value="{{ $satuan['id'] }}">{{ $satuan['kode_satuan'] }}</option>
                                            @endforeach

                                        </select>
                                        <label for="floatingSelect">Satuan Barang</label>
                                        @error('satuan_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />

    <script>
        (function() {
            const hargaInput = document.getElementById('harga-barang');

            if (!hargaInput) return;

            hargaInput.addEventListener('input', function() {
                let value = this.value.replace(/[^0-9]/g, ""); // hanya angka
                if (value) {
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                } else {
                    this.value = "";
                }
            });
        })();
    </script>
</div>