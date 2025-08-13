<div>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>

    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Input Barang Keluar</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Input Outcome Items</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <div wire:ignore.self>
                @if($successMessage)
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ $successMessage }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errorMessage)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    {{ $errorMessage }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>

            <a href="{{route('appDashboardPage')}}" class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Data Barang Keluar</h5>
                            <form class="row g-3" wire:submit.prevent="saveBarangKeluar">
                                <div class="card-body profile-card d-flex flex-column align-items-center">

                                    <div class="col-12" wire:ignore>
                                        <label class="form-label">Barang yang keluar</label>
                                        <select wire:model="item_id" wire:change="cekStok($event.target.value)" style="width: 100%;" id="selectItem" required>
                                            <option value="">-Pilih Barang-</option>
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

                                    <div class="col-12">
                                        <label class="form-label">Jumlah</label>
                                        <input type="text" class="form-control" placeholder="Banyaknya barang yang keluar" wire:model="jumlah">
                                        @error('jumlah')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Berat Total</label>
                                        <input type="text" class="form-control" placeholder="Berat total barang yang keluar" wire:model="berat_total">
                                        @error('berat_total')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Keterangan (opsional)</label>
                                        <textarea style="height: 100px" class="form-control" placeholder="Keterangan barang keluar" wire:model="keterangan"></textarea>
                                    </div>
                                    <div class="text-center pt-2">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stok ketersediaan {{$stokData['nama_barang']??''}}</h5>
                            <div id="loading" wire:loading wire:target="cekStok" style="text-align: center;">
                                <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                <p>loading...</p>
                            </div>

                            <div wire:loading.remove wire:target="cekStok">
                                @if($stokData)
                                <p><strong>Stok :</strong> {{ $stokData['stok']['jumlah']??'0' }} {{ $stokData['satuan']['nama_satuan']??'' }}</p>
                                <p><strong>Berat total :</strong> {{ $stokData['stok']['berat_total']??'0' }}</p>
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

    @script
    <script>
        $wire.on('success-message', (event) => {

            setTimeout(function() {
                let alert = document.getElementById('success-alert');
                if (alert) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
                $wire.set('successMessage', null);
            }, 4000);
        });
    </script>
    @endscript

    <livewire:PartialView.App.Footer />
</div>