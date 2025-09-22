<div>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>

    <livewire:PartialView.App.Header />

    <livewire:PartialView.App.Sidebar />

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Transaksi Pengembalian (Kembali)</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('appDashboardPage')}}">Home</a></li>
                    <li class="breadcrumb-item active">Transaction</li>
                    <li class="breadcrumb-item active">Pengembalian</li>
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
            <button type="button" onclick="window.location.reload(true)" class="btn btn-primary btn-sm mb-2"><i class="bi bi-arrow-clockwise me-1"></i>Refresh</button>
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
                            <input wire:model="qrResult" type="hidden" id="qrResult">
                        </div>
                    </div>
                </div>

                <div class="col-8">
                    <div class="card">
                        <div class="card-body" wire:poll="fetchResultPool">
                            <h5 class="card-title">Data Pengrajin <span class="text-muted">SILAHKAN REFRESH HALAMAN JIKA INGIN SCAN BARCODE PENGRAJIN LAIN</span></h5>

                            @if(!empty($pengrajinData) && $pengrajinData['is_found'])
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nama Pengrajin</div>
                                <div class="col-lg-9 col-md-8">{{$pengrajinData['nama_pengrajin']}}</div>
                            </div>
                            <form wire:submit.prevent="savePengembalian">

                                <div class="row pt-4">
                                    <div class="col-lg-3 col-md-4 label ">Transaksi</div>
                                    <div class="col-lg-9 col-md-8" wire:ignore>

                                        <select id="selectTrx" wire:model="transactionId" wire:change="calculateUpah" style="width:100%;"
                                            wire:key="selectTrx-{{ count($transactionListLite) }}">
                                            <option value="">-Pilih Transaksi-</option>
                                            @foreach ($transactionListLite as $trx)
                                            <option value="{{ $trx['id'] }}">
                                                {{ explode('-', $trx['id'])[1] }} | {{ $trx['tanggal_pengambilan'] }}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @error('transactionId')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row pt-4">
                                    <div class="col-lg-3 col-md-4 label ">Upah (Harga barang X berat ambil)</div>
                                    <div class="col-lg-9 col-md-8"><b>Rp. {{number_format($upah??0, 0, ',', '.')}}</b></div>
                                </div>

                                <div class="row pt-4">
                                    <div class="col-lg-3 col-md-4 label ">Barang Kembali</div>
                                    <div class="col-lg-9 col-md-8" wire:ignore>

                                        <select id="selectItem" wire:model="itemId" style="width:100%;"
                                            wire:key="selectItem-{{ count($inventoryItemList) }}">
                                            <option value="">-Pilih Barang-</option>
                                            @foreach ($inventoryItemList as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['nama_kategori'] }} | {{ $item['nama_barang'] }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @error('itemId')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row pt-4">
                                    <div class="col-lg-3 col-md-4 label ">Quantity (Berat Kembali)</div>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="text" class="form-control" placeholder="Banyaknya barang yang dikembalikan" wire:model="berat_pengembalian">

                                    </div>
                                    @error('berat_pengembalian')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-center pt-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>

                            </form>

                            @elseif(!empty($pengrajinData))
                            <div class="pt-2">
                                <p>Tolong arahkan barcode ke kamera untuk melanjutkan</p>
                            </div>
                            @endif


                        </div>
                    </div>
                </div>

            </div>

            @if(!empty($pengrajinData) && $pengrajinData['is_found'])
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Transaksi Pengrajin {{$pengrajinData['nama_pengrajin']}} Pada bulan {{$bulanIni}}</h5>

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">TRX_ID</th>
                                        <th scope="col">Tanggal Ambil</th>
                                        <th scope="col">Berat Ambil</th>
                                        <th scope="col">Tanggal Kembali</th>
                                        <th scope="col">Berat Kembali</th>
                                        <th scope="col"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactionList as $transactData)
                                    <tr>
                                        <th scope="row">{{ explode('-', $transactData['id'])[1] }}</th>
                                        <td>{{ $transactData['timestamp_pengambilan'] }}</td>
                                        <td>{{ $transactData['berat_pengambilan'] }}</td>

                                        <td>
                                            @if ($transactData['timestamp_pengembalian'])
                                            {{ $transactData['timestamp_pengembalian'] }}
                                            @else
                                            <span class="text-danger">BELUM ADA</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($transactData['berat_pengembalian'])
                                            {{ $transactData['berat_pengembalian'] }}
                                            @else
                                            <span class="text-danger">BELUM ADA</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{route('appTransactionDetails', ['transactionId'=> $transactData['id']])}}">Detail</a>
                                        </td>
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

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        (function() {
            const cameraLoading = document.getElementById("camera-loading");
            const readerDiv = document.getElementById("reader");

            const html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    // cari kamera belakang
                    let backCamera = devices.find(d =>
                        d.label.toLowerCase().includes("back") ||
                        d.label.toLowerCase().includes("environment")
                    );

                    const cameraId = backCamera ? backCamera.id : devices[0].id;

                    html5QrCode.start(
                        cameraId, {
                            fps: 10,
                            qrbox: 250
                        },
                        qrCodeMessage => {
                            document.getElementById('qrResult').value = qrCodeMessage;
                            document.getElementById('qrResult').dispatchEvent(new Event('input'));
                        },
                        errorMessage => {
                            // optional error log
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


    <script>
        (function() {
            let ssTrx = null;
            let ssItem = null;

            function initSlim() {
                const trxEl = document.getElementById('selectTrx');
                const itemEl = document.getElementById('selectItem');

                if (trxEl) {
                    if (ssTrx && typeof ssTrx.destroy === 'function') ssTrx.destroy();
                    ssTrx = new SlimSelect({
                        select: trxEl
                    });
                }

                if (itemEl) {
                    if (ssItem && typeof ssItem.destroy === 'function') ssItem.destroy();
                    ssItem = new SlimSelect({
                        select: itemEl
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', initSlim);

            // Livewire event
            window.addEventListener('init-slim-select', () => {
                requestAnimationFrame(initSlim);
            });
        })();
    </script>

    <livewire:PartialView.App.Footer />
</div>