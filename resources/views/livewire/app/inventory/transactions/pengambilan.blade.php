<div>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>

    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Transaksi Pengambilan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Transaction</li>
                    <li class="breadcrumb-item active">Pengambilan</li>
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

            <a href="{{route('appDashboardPage')}}" class="btn btn-secondary btn-sm mb-2"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body" wire:ignore>
                            <h5 class="card-title">Arahkan barcode pengrajin ke kamera</h5>
                            <div id="camera-loading" style="text-align: center;">
                                <img width="80" height="80" src="{{ url(env('APP_ASSET_URL') . '/img/loading.gif') }}" alt="Loading...">
                                <p>Memuat kamera...</p>
                            </div>

                            <div id="reader" style="width: 100%; visibility: hidden; height: 0;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <input wire:model="qrResult" type="hidden" id="qrResult">

                        <div class="card-body" wire:poll="fetchResult">
                            <h5 class="card-title">Data Pengambilan</h5>
                            <form class="row g-3" wire:submit.prevent="savePengambilan">
                                <div class="profile-card d-flex flex-column align-items-center">

                                    <div class="col-12" wire:ignore>
                                        <label class="form-label">Barang yang diambil</label>
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

                                    @if(!empty($pengrajinData) && $pengrajinData['is_found'])

                                    <div class="col-12 pt-2">
                                        <label class="form-label">Nama Pengrajin</label>
                                        <input type="text" readonly class="form-control" value="{{ $pengrajinData['nama_pengrajin'] }}">
                                    </div>

                                    <div class="col-12 pt-2">
                                        <label class="form-label">Quantity</label>
                                        <input type="text" class="form-control" placeholder="Banyaknya barang yang diambil" wire:model="berat_pengambilan">
                                        @error('berat_pengambilan')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center pt-2">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                    @elseif(!empty($pengrajinData))
                                    <div class="pt-2"><p>Tolong arahkan barcode ke kamera untuk melanjutkan</p></div>
                                    @endif
                                </div>
                            </form>
                        </div>


                    </div>
                </div>

                <div class="col-4">
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

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        (function() {
            const cameraLoading = document.getElementById("camera-loading");
            const readerDiv = document.getElementById("reader");

            const html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    const cameraId = devices[0].id;

                    html5QrCode.start(
                        cameraId, {
                            fps: 10,
                            qrbox: 250
                        },
                        qrCodeMessage => {
                            // alert("Scan berhasil: " + qrCodeMessage);
                            document.getElementById('qrResult').value = qrCodeMessage;
                            document.getElementById('qrResult').dispatchEvent(new Event('input'));
                        },
                        errorMessage => {
                            // optional error
                        }
                    ).then(() => {
                        cameraLoading.style.display = "none";
                        readerDiv.style.visibility = "visible";
                        readerDiv.style.height = "auto";
                    }).catch(err => {
                        cameraLoading.innerHTML = "<p style='color:red'>Gagal mengakses kamera.</p>";
                    });
                }
            }).catch(err => {
                cameraLoading.innerHTML = "<p style='color:red'>Tidak ada kamera ditemukan.</p>";
            });
        })();
    </script>

    <livewire:PartialView.App.Footer />
</div>