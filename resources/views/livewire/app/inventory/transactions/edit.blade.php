<div>
    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Update Transaksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item">Pengrajin Master</li>
                    <li class="breadcrumb-item">Detail</li>
                    <li class="breadcrumb-item">Visit Log</li>
                    <li class="breadcrumb-item">Transaction Details</li>
                    <li class="breadcrumb-item active">Update</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            @if(session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <a href="{{route('appTransactionDetails', ['transactionId'=>$transactionData['id']])}}" wire:navigate class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
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
                        <form wire:submit.prevent="updateTrxAmbil">
                            <div class="card-body">
                                <h5 class="card-title">Data Pengambilan(Ambil)</h5>

                                <div class="row mb-3" wire:ignore>
                                    <label class="col-sm-6 col-form-label">Waktu Pengambilan</label>
                                    <div class="col-sm-6">
                                        <input type="text" value="{{$transactionData['timestamp_pengambilan']}}" id="waktuPengambilanInput" class="form-control" placeholder="Pilih tanggal & waktu">
                                        <input type="hidden" wire:model="waktuPengambilan" id="waktuPengambilan">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-6 col-form-label">Berat Pengambilan</label>
                                    <div class="col-sm-6">
                                        <div class="input-group mb-3">
                                            <input wire:model="beratPengambilan" type="number" step="any" min="0" class="form-control" placeholder="misal: 10.0">
                                            <span class="input-group-text">{{$satuanData['kode_satuan']}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <button id="saveTrxAmbil" type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <form wire:submit.prevent="updateTrxKembali">
                            <div class="card-body">
                                <h5 class="card-title">Data Pengembalian(Kembali)</h5>

                                <div class="row mb-3">
                                    <label class="col-sm-6 col-form-label">Waktu Pengembalian</label>
                                    <div class="col-sm-6">
                                        <input type="text" value="{{$transactionData['timestamp_pengembalian']}}" id="waktuPengembalianInput" class="form-control" placeholder="Pilih tanggal & waktu">
                                        <input type="hidden" wire:model="waktuPengembalian" id="waktuPengembalian">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-6 col-form-label">Berat Pengembalian</label>
                                    <div class="col-sm-6">
                                        <div class="input-group mb-3">
                                            <input wire:model="beratPengembalian" type="number" step="any" min="0" class="form-control" placeholder="misal: 10.0">
                                            <span class="input-group-text">{{$satuanData['kode_satuan']}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button id="saveTrxKembali" type="submit" class="btn btn-primary">Simpan</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <livewire:PartialView.App.Footer />

    <script>
        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                // === WAKTU PENGAMBILAN ===
                flatpickr("#waktuPengambilanInput", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i:S",
                    time_24hr: true,
                    defaultDate: document.getElementById("waktuPengambilan").value || null,
                    onChange: function(selectedDates, dateStr) {
                        const hidden = document.getElementById("waktuPengambilan");
                        hidden.value = dateStr;
                        hidden.dispatchEvent(new Event("input"));
                    }
                });

                // === WAKTU PENGEMBALIAN ===
                flatpickr("#waktuPengembalianInput", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i:S",
                    time_24hr: true,
                    defaultDate: document.getElementById("waktuPengembalian").value || null,
                    onChange: function(selectedDates, dateStr) {
                        const hidden = document.getElementById("waktuPengembalian");
                        hidden.value = dateStr;
                        hidden.dispatchEvent(new Event("input"));
                    }
                });
            });
        })();
    </script>

</div>